<?php

/* 
 * Контроллер страницы категорий
 */

//подключение модели
include_once '../models/CategoriesModel.php';
include_once '../models/ProductsModel.php';

/**
 * Формирование страницы категорий
 * @param object $smarty шаблонизатор
 */
function indexAction($smarty) {
    $catId = isset($_GET['id']) ? $_GET['id'] : null;
    if(! $catId) exit();
    $rsChildren = null;
    $rsProducts = null;
    $rsCategory = getCatById($catId); //главная либо дочерняя категория
    
    //если главная то показываем дочерние
    //иначе показываем товар
    if ($rsCategory['parent_id'] == 0) {
        $rsChildren = getChildrenForCat($catId);
    } else {
        $rsProducts = getProductsByCat($catId);
    }
    
    $rsCategories = getAllMainCatsWithChildren();
    
    $smarty->assign('PageTitle', 'Товары категории ' .$rsCategory['name']);
    
    $smarty->assign('rsCategory', $rsCategory);
    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('rsChildren', $rsChildren);
    $smarty->assign('rsProducts', $rsProducts);

    loadTemplate($smarty, 'header');
    loadTemplate($smarty, 'category');
    loadTemplate($smarty, 'footer');
}
