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

