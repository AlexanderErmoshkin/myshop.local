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
    $db = setConnection();
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
    
    $rs = mysqli_query($db, $sql);
    
    //получить id созданного заказа
    //переделать
    if ($rs) {
        $sql = 'SELECT id FROM orders ORDER BY id DESC LIMIT 1';
        $rs = mysqli_query($db, $sql);
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
    $db = setConnection();
    $userId = intval($userId);
    $sql = "SELECT * FROM orders
        WHERE `user_id` = '{$userId}'
        ORDER BY id DESC";
        
    $rs = mysqli_query($db, $sql);
    
    $smartyRs = array();
    while($row = mysqli_fetch_assoc($rs)) {
        $rsChildren = getPurchaseForOrder($row['id']);
        
        if ($rsChildren) {
            $row['children'] = $rsChildren;
            $smartyRs[] = $row;
        }
    }
    return $smartyRs;
}

function getOrders() {
    $db = setConnection();
    $sql = "SELECT o.*, u.name, u.email, u.phone, u.adress
            FROM orders as `o`
            LEFT JOIN users AS `u` ON o.user_id = u.id
            ORDER BY id DESC";
    
    $rs = mysqli_query($db, $sql);
    
    $smartyRs = array();
    while($row = mysqli_fetch_assoc($rs)) {
        $rsChildren = getProductsForOrder($row['id']);
        
        if ($rsChildren) {
            $row['children'] = $rsChildren;
            $smartyRs[] = $row;
        }
    }
    return $smartyRs;
}

/**
 * Получить товары заказа
 * @param integer $orderId ID заказа
 * @return array массив данных товаров
 */
function getProductsForOrder($orderId) {
    $db = setConnection();
    $sql = "SELECT * FROM purchase AS pe
            LEFT JOIN products AS ps
            ON pe.product_id = ps.id
            WHERE (`order_id` = '{$orderId}')";
    
    $rs = mysqli_query($db, $sql);
    return createSmartyArray($rs);
}

function updateOrderStatus($itemId, $status) {
    $db = setConnection();
    $status = intval($status);
    $sql = "UPDATE orders SET `status` = '{$status}' WHERE id = '{$itemId}'";
    $rs = mysqli_query($db, $sql);
    return $rs;
}

function updateOrderDatePayment($itemId, $datePayment) {
    $db = setConnection();
    $sql = "UPDATE orders SET `date_payment` = '{$datePayment}' WHERE id = '{$itemId}'";
    $rs = mysqli_query($db, $sql);
    return $rs;
}