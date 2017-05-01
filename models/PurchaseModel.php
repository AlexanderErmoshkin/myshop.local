<?php

/**
 * Внесение в БД данных продуктов с привязкой к заказу
 * @param integer $orderId id заказа
 * @param array $cart массив корзины
 * @return booolean TRUE в случае успешного добавления в БД
 */
function setPurchaseForOrder($orderId, $cart) {
    $db = setConnection();
    $sql = "INSERT INTO purchase
            (order_id, product_id, price, amount)
            VALUES ";
    $values = array();
    foreach ($cart as $item) {
        $values[] = "('{$orderId}', '{$item['id']}', '{$item['price']}', '{$item['cnt']}')";
    }
            
    $sql .= implode($values, ', ');
    $rs = mysqli_query($db, $sql);
    
    return $rs; 
}

function getPurchaseForOrder($orderId) {
    $db = setConnection();
    $sql = "SELECT `pe`.*, `ps`.`name`
            FROM purchase as `pe`
            JOIN products as `ps` ON `pe`.product_id = `ps`.id
            WHERE `pe`.order_id = {$orderId}";
    $rs = mysqli_query($db, $sql);
    return createSmartyArray($rs);
}

