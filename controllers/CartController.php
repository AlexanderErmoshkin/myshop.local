<?php

include_once "../models/CategoriesModel.php";
include_once "../models/ProductsModel.php";
/**
 * Добавление продукта в корзину
 * @return json информация об операции
 */
function addtocartAction(){
    $itemId = isset($_GET['id']) ? intval($_GET['id']) : null;
    if (! $itemId){
        return false;
    }
    
    $resData = array();
    
    if (isset($_SESSION['cart']) && array_search($itemId, $_SESSION['cart']) === false) {
        $_SESSION['cart'][] = $itemId;
        $resData['cartCntItems'] = count($_SESSION['cart']);
        $resData['success'] = 1;       
    } else {
        $resData['success'] = 0;
    }
    
    echo json_encode($resData);
}

function removefromcartAction() {
    $itemId = isset($_GET['id']) ? intval($_GET['id']) : null;
    if (! $itemId) exit();
    
    $resData = array();
    $key = array_search($itemId, $_SESSION['cart']);
    if($key !== false) {
        unset($_SESSION['cart'][$key]);
        $resData['success'] = 1;
        $resData['cartCntItems'] = count($_SESSION['cart']);
    } else {
        $resData['success'] = 0;
    }
    echo json_encode($resData);
}

/**
 * Формирование  страницы корзины 
 * @link /cart/
 */
function indexAction($smarty) {
    $itemsId = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    
    $rsCategories = getAllMainCatsWithChildren();
    $rsProducts = getProductsFromArray($itemsId);
    
    $smarty->assign('PageTitle', 'Корзина');
    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('rsProducts', $rsProducts);
    
    loadTemplate($smarty, 'header');
    loadTemplate($smarty, 'cart');
    loadTemplate($smarty, 'footer');
}