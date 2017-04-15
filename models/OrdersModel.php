<?php

/**
 * Создание заказа (без привязки товара)
 * 
 * @param string $name имя 
 * @param string $phone телефон
 * @param string $adress адрес
 * @return integer id созданного заказа
 */
function makeNewOrder($name, $phone, $adress) {
    //> инициализация переменных
    $userId = $_SESSION['user']['id'];
    $comment = 'id пользователя: ' . $userId . '<br/>'
            . 'имя: ' . $name . '<br/>'
            . 'телефон: ' . $phone . '<br/>'
            . 'адрес: ' . $adress;
    $dateCreated = date('Y.m.d H:i:s');
    $userIp = $_SERVER['REMOTE_ADDR'];  //переделать
    //<
    
    $sql = "INSERT INTO "
            . "orders (`user_id`, `date_created`, `date_payment`, `status`, `comment`, `user_ip`)"
            . "VALUES ('" . $userId ."', '" . $dateCreated . "', null, '0', '"
            . $comment . "', '" . $userIp . "')";
    
    $rs = mysql_query($sql);
    
    //получить id созданного заказа
    //переделать
    if ($rs) {
        $sql = 'SELECT id FROM orders ORDER BY id DESC LIMIT 1';
        $rs = mysql_query($sql);
        $rs = createSmartyArray($rs);
        
        if (isset($rs[0])) {
            return $rs[0]['id'];
        }
    }
    
    return false;
}

/**
 * получить список заказов с привязкой к товарам для пользователя $userId
 * @param integer $userId
 * @return array массив заказов с привязкой к товарам
 */
function getOrdersWithProductsByUser($userId) {
    $userId = intval($userId);
    $sql = "SELECT * FROM orders
        WHERE `user_id` = '{$userId}'
        ORDER BY id DESC";
        
    $rs = mysql_query($sql);
    
    $smartyRs = array();
    while($row = mysql_fetch_assoc($rs)) {
        $rsChildren = getPurchaseForOrder($row['id']);
        
        if ($rsChildren) {
            $row['children'] = $rsChildren;
            $smartyRs[] = $row;
        }
    }
    return $smartyRs;
}