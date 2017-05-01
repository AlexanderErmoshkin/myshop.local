<?php

/**
 * Регистрация нового пользователя
 * @param string $email почта
 * @param string $pwdMD5 пароль зашифрованный в MD5
 * @param string $name имя 
 * @param string $phone телефон
 * @param string $adress адрес пользователя
 * @return array массив данных нового пользователя
 */
function registerNewUser($email, $pwdMD5, $name, $phone, $adress){
    $db = setConnection();
    $email = htmlspecialchars(mysqli_real_escape_string($db, $email));
    $name = htmlspecialchars(mysqli_real_escape_string($db, $name));
    $phone = htmlspecialchars(mysqli_real_escape_string($db, $phone));
    $adress = htmlspecialchars(mysqli_real_escape_string($db, $adress));
    
    $sql = "INSERT INTO users (`email`, `pwd`, `name`, `phone`, `adress`)"
            . "VALUES ('".$email."', '".$pwdMD5."', '".$name."', '".$phone."', '".$adress."')";
    
    $rs = mysqli_query($db, $sql);
    
    if($rs) {
        $sql = "SELECT * FROM users WHERE (`email` = '".$email."' and `pwd` = '".$pwdMD5."') LIMIT 1";
        
        $rs = mysqli_query($db, $sql);
        $rs = createSmartyArray($rs);
        
        if(isset($rs[0])) {
            $rs['success'] = 1;
        } else {
            $rs['success'] = 0;
        }
    } else {
        $rs['success'] = 0;
    }
    return $rs;
}

function checkRegisterParams($email, $pwd1, $pwd2) {
    $res = null;
    
    if (! $email) {
        $res['success'] = false;
        $res['message'] = 'Введите email';
    } elseif (! $pwd1) {
        $res['success'] = false;
        $res['message'] = 'Введите пароль';
    } elseif (! $pwd2) {
        $res['success'] = false;
        $res['message'] = 'Введите пароль еще раз';
    } elseif ($pwd1 != $pwd2) {
        $res['success'] = false;
        $res['message'] = 'Пароли не совпадают';
    }
    
    return $res;
}

/**
 * Проверка почты на единтичность
 * @param string $email
 * @return array строка из таблицы users, лиюо пустой массив
 */
function checkUserEmail($email) {
    $db = setConnection();
    $email = mysqli_real_escape_string($db, $email);
    $sql = "SELECT id FROM users WHERE email = '".$email."'";
    
    $rs = mysqli_query($db, $sql);
    $rs = createSmartyArray($rs);
    
    return $rs;
}

function loginUser($email, $pwd) {
    $db = setConnection();
    $email = htmlspecialchars(mysqli_real_escape_string($db, $email));
    $pwd =md5($pwd);
    
    $sql = "SELECT * FROM users WHERE (`email` = '".$email."' and `pwd` = '".$pwd."') LIMIT 1";
    
    $rs = mysqli_query($db, $sql);
    
    $rs = createSmartyArray($rs);
    
    if(isset($rs[0])) {
        $rs['success'] = 1;
    } else {
        $rs['success'] = 0;
    }
    return $rs;
}

/**
 * Изменение данных пользователя
 * @param string $name имя пользователя
 * @param string $phone телефон
 * @param string $adress адрес
 * @param string $pwd1 новый пароль 
 * @param string $pwd2 повтор пароля
 * @param string $curPwd текущий пароль
 * @return boolean TRUE в случае успеха
 */
function updateUserData($name, $phone, $adress, $pwd1, $pwd2, $curPwd) {
    $db = setConnection();
    
    $email = htmlspecialchars(mysqli_real_escape_string($db, $_SESSION['user']['email']));
    $name = htmlspecialchars(mysqli_real_escape_string($db, $name));
    $phone = htmlspecialchars(mysqli_real_escape_string($db, $phone));
    $adress = htmlspecialchars(mysqli_real_escape_string($db, $adress));
    $pwd1 = trim($pwd1);
    $pwd2 = trim($pwd2);
    
    $newPwd = null;
    if ($pwd1 && ($pwd1 == $pwd2)) {
        $newPwd = md5($pwd1);
    }
    
    $sql = 'UPDATE users SET ';
    
    if ($newPwd) {
        $sql .= "`pwd` = '".$newPwd ."', ";
    }
    
    $sql .= "`name` = '".$name ."', "
            ."`phone` = '".$phone ."', "
            ."`adress` = '".$adress ."' WHERE "
            ."`email` = '".$email ."' AND `pwd` = '".$curPwd ."' LIMIT 1";
    
    $rs = mysqli_query($db, $sql);
    
    return $rs;
}

/**
 * Получить данные заказа текущего пользователя
 * @return array массив заказов с привязкой к прдуктам
 */
function getCurUserOrders() {
    $userId = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 0;
    $rs = getOrdersWithProductsByUser($userId);
    
    return $rs;
}
