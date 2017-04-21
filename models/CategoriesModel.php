<?php

/**
 * Модель таблицы категорий
 */

/**
 * Получить дочерние категории для категории $CatId
 * 
 * @param integer $CatId
 * @return array массив дочерних категорий
 */
function getChildrenForCat($CatId) {
    $sql = 'SELECT * FROM categories WHERE parent_id = ' .$CatId;
    
    $rs = mysql_query($sql);
    
    return createSmartyArray($rs);
}

/**
 * Получить главные категории с привязкой дочерних
 * @return array массив категорий
 */
function getAllMainCatsWithChildren() {
    $sql = 'SELECT * FROM categories WHERE parent_id = 0';
    $rs = mysql_query($sql);
    
    $smartyRs = array();
    
    while ($row = mysql_fetch_assoc($rs)) {
        
        $rsChildren = getChildrenForCat($row['id']);
        if ($rsChildren) {
            $row['children'] = $rsChildren;
        }
        
        $smartyRs[] = $row;
    }
    
    return $smartyRs;
}

/**
 * Получить данные категорий по id
 * @param integer $catId Id категорий
 * @return array строка категорий
 */
function getCatById($catId) {
    $catId = intval($catId);
    $sql = "SELECT * FROM categories WHERE id = " .$catId;
    
    $rs = mysql_query($sql);
    return mysql_fetch_assoc($rs);
}

/**
 * Получить все главные категории
 * @return array массив категорий
 */
function getAllMainCategories() {
    $sql = "SELECT * FROM categories WHERE parent_id = 0";
    $rs = mysql_query($sql);
    
    return createSmartyArray($rs);
}

/**
 * Добавление новой категории
 * @param string $catName имя категории
 * @param integer $catParentId id родительской категории
 * @return integer id новой категории
 */
function insertCat($catName, $catParentId = 0) {
    $sql = "INSERT INTO categories (`parent_id`, `name`) 
            VALUES ('{$catParentId}', '{$catName}')";
    mysql_query($sql);
    
    $id = mysql_insert_id();
    return $id;
}

/**
 * получить все категории
 * @return array массив категорий
 */
function getAllCategories() {
    $sql = "SELECT * FROM categories ORDER BY parent_id ASC";
    
    $rs = mysql_query($sql);
    return createSmartyArray($rs);
}

/**
 * 
 * @param int $itemId id категории
 * @param int $parentId id родительской категории
 * @param string $newName новое имя категории
 */
function updateCategoryData($itemId, $parentId = -1, $newName = '') {
    $set = array();
    
    if ($newName) {
        $set[] = "`name` = '{$newName}'";
    }
    if ($parentId > -1) {
        $set[] = "`parent_id` = '{$parentId}'";
    }
    $setStr = implode($set, ', ');
    $sql = "UPDATE categories SET {$setStr} WHERE id = '{$itemId}'";
    $rs = mysql_query($sql);
    return $rs;
}