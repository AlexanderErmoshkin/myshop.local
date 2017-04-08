<?php

/**
 * Контроллер страницы товара
 */

include_once '../models/ProductsModel.php';
include_once '../models/CategoriesModel.php';

/**
 * формирование страницы товара
 * @param type $smarty
 */
function indexAction($smarty) {
    $itemId = isset($_GET['id']) ? $_GET['id'] : null;
    if (! $itemId) exit();
    
    //получить данные продукта
    $rsProduct = getProductById($itemId);
    
    //получить все категории
    $rsCategories = getAllMainCatsWithChildren();
    
    $smarty->assign('itemInCart', 0);
    if (in_array($itemId, $_SESSION['cart'])) {
        $smarty->assign('itemCart', 1);
    }
    
    $smarty->assign('PageTitle', '');
    $smarty->assign('rsProduct', $rsProduct);
    $smarty->assign('rsCategories', $rsCategories);
    
    loadTemplate($smarty, 'header');
    loadTemplate($smarty, 'product');
    loadTemplate($smarty, 'footer');
}