<?php

/* 
 * Модель для таблицы продукции
 */

function getLastProducts($limit = null) {
    $sql = "SELECT * FROM products ORDER BY id DESC";
    if($limit) {
        $sql .= " LIMIT " .$limit;
    }
    
    $rs = mysql_query($sql);
    return createSmartyArray($rs);
}

/**
 * Получить продукты для категории $itemId
 * @param integer $itemId Id категории
 * @return array массив продуктов
 */
function getProductsByCat($itemId) {
    $itemId = intval($itemId);
    $sql = "SELECT * FROM products WHERE category_id = " .$itemId;
    $rs = mysql_query($sql);
    return createSmartyArray($rs);
}

/**
 * получить данные продукта по Id
 * @param integer $itemId Id продукта
 * @return array массив данных продукта
 */
function getProductById($itemId) {
    $itemId = intval($itemId);
    $sql = "SELECT * FROM products WHERE id = " .$itemId;
    $rs = mysql_query($sql);
    return mysql_fetch_assoc($rs);
}

/**
 * Получить список продуктов по массиву идентификаторов
 * @param array $itemsId массив идентификаторов продуктов
 * @return array массив данных продуктов
 */
function getProductsFromArray($itemsId) {
    $strIds = implode($itemsId, ', ');
    $sql = "SELECT * FROM products WHERE id in (" .$strIds .")";
    
    $rs = mysql_query($sql);
    return createSmartyArray($rs);
}

/**
 * получить все продукты
 */
function getProducts() {
    $sql = "SELECT * FROM products ORDER BY category_id";
    $rs = mysql_query($sql);
    return createSmartyArray($rs);
}

/**
 * Добавление нового товара
 * @param string $itemName имя товара
 * @param float $itemPrice цена товара
 * @param string $itemDescr описание товара
 * @param integer $itemCat id категория товара
 * @return boolean результат операции
 */
function insertProduct($itemName, $itemPrice, $itemDescr, $itemCat) {
    $sql = "INSERT INTO products SET
            `name` = '{$itemName}',
            `price` = '{$itemPrice}',
            `description` = '{$itemDescr}',
            `category_id` = '{$itemCat}'";
    $rs = mysql_query($sql);
    return $rs;
}
