<?php

/**
 * Внесение в БД данных продуктов с привязкой к заказу
 * @param integer $orderId id заказа
 * @param array $cart массив корзины
 * @return booolean TRUE в случае успешного добавления в БД
 */
function setPurchaseForOrder($orderId, $cart) {
    
    $sql = "INSERT INTO purchase
            (order_id, product_id, price, amount)
            VALUES ";
    $values = array();
    foreach ($cart as $item) {
        $values[] = "('{$orderId}', '{$item['id']}', '{$item['price']}', '{$item['cnt']}')";
    }
            
    $sql .= implode($values, ', ');
    
    $rs = mysql_query($sql);
    
    return $rs; 
}

