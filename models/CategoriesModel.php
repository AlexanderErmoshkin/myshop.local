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
    $db = setConnection();
    $rs = mysqli_query($db, $sql);
    
    return createSmartyArray($rs);
}

/**
 * Получить главные категории с привязкой дочерних
 * @return array массив категорий
 */
function getAllMainCatsWithChildren() {
    $sql = 'SELECT * FROM categories WHERE parent_id = 0';
    $db = setConnection();
    $rs = mysqli_query($db, $sql);
    
    $smartyRs = array();
    
    while ($row = mysqli_fetch_assoc($rs)) {
        
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
    $db = setConnection();
    
    $catId = intval($catId);
    $sql = "SELECT * FROM categories WHERE id = " .$catId;
    
    $rs = mysqli_query($db, $sql);
    return mysqli_fetch_assoc($rs);
}

/**
 * Получить все главные категории
 * @return array массив категорий
 */
function getAllMainCategories() {
    $db = setConnection();
    $sql = "SELECT * FROM categories WHERE parent_id = 0";
    $rs = mysqli_query($db, $sql);
    
    return createSmartyArray($rs);
}

/**
 * Добавление новой категории
 * @param string $catName имя категории
 * @param integer $catParentId id родительской категории
 * @return integer id новой категории
 */
function insertCat($catName, $catParentId = 0) {
    $db = setConnection();
    $sql = "INSERT INTO categories (`parent_id`, `name`) 
            VALUES ('{$catParentId}', '{$catName}')";
    mysqli_query($db, $sql);
    
    $id = mysqli_insert_id();
    return $id;
}

/**
 * получить все категории
 * @return array массив категорий
 */
function getAllCategories() {
    $db = setConnection();
    $sql = "SELECT * FROM categories ORDER BY parent_id ASC";
    
    $rs = mysqli_query($db, $sql);
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
    $db = setConnection();
    
    if ($newName) {
        $set[] = "`name` = '{$newName}'";
    }
    if ($parentId > -1) {
        $set[] = "`parent_id` = '{$parentId}'";
    }
    $setStr = implode($set, ', ');
    $sql = "UPDATE categories SET {$setStr} WHERE id = '{$itemId}'";
    $rs = mysqli_query($db, $sql);
    return $rs;
}