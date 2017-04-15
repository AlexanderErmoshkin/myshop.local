<?php

include_once "../models/CategoriesModel.php";
include_once "../models/ProductsModel.php";
include_once "../models/OrdersModel.php";
include_once "../models/PurchaseModel.php";
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

/**
 * Формирование страницы заказа
 */
function orderAction($smarty) {
    //получение массива id товаров в корзине
    $itemIds = isset($_SESSION['cart']) ? $_SESSION['cart'] : null;
    //если корзина пуста то редирект в корзину
    if (! $itemIds) {
        redirect('/cart/');
        return;
    }
    
    //получим из $_POSTколичество покупаемых товаров
    $itemsCnt = array();
    foreach($itemIds as $item) {
        //формирование ключа для массива POST
        $postVar = 'itemCnt_' . $item;
        $itemsCnt[$item] = isset($_POST[$postVar]) ? $_POST[$postVar] : null;
    }
    
    $rsProducts = getProductsFromArray($itemIds);
    
    //добавление дополнительного поля каждому продукту
    //realPricee = кол-во продукта * цена
    $i = 0;
    foreach ($rsProducts as &$item) {
        $item['cnt'] = isset($itemsCnt[$item['id']]) ? $itemsCnt[$item['id']] : 0;
        if ($item['cnt']) {
            $item['realPrice'] = $item['cnt'] * $item['price'];
        } else {
            //если товар оказался в корзине, а его кол-во = 0, удаляем товар
            unset($rsProducts[$i]);
        }
        $i++;
    }
    
    if (! $rsProducts) {
        echo 'Корзина пуста';
        return;
    }
    
    //полученный массив покупаемых товаров поместим в сессионную переменную
    $_SESSION['saleCart'] = $rsProducts;
    
    $rsCategories = getAllMainCatsWithChildren();
    
    if (! isset($_SESSION['user'])) {
        $smarty->assign('hideLoginBox', 1);
    }
    
    $smarty->assign('PageTitle', 'Заказ');
    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('rsProducts', $rsProducts);
    
    loadTemplate($smarty, 'header');
    loadTemplate($smarty, 'order');
    loadTemplate($smarty, 'footer');
    
}

/**
 * AJAX функция сохранения заказа
 * 
 * @param array $_SESSION['saleCart'] массив покупаемых продуктов
 * @return json информация о результате
 */
function saveorderAction() {
    //получение массива купленнных товаров
    $cart = isset($_SESSION['saleCart']) ? $_SESSION['saleCart'] : null;
    
    if (! $cart) {
        $resData['success'] = 0;
        $resData['message'] = 'Нет товаров для заказа';
        echo json_encode($resData);
        return;
    }
    
    //дальше сделать проверку переменных
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
    $adress = isset($_POST['adress']) ? $_POST['adress'] : null;
    
    //создаемновы заказ и получаем его id
    $orderId = makeNewOrder($name, $phone, $adress);
    
    if (! $orderId) {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка создания заказа';
        echo json_encode($resData);
        return;
    }
    
    //сохранение товаров для заказа
    $res = setPurchaseForOrder($orderId, $cart);
    
    if ($res) {
        $resData['success'] = 1;
        $resData['message'] = 'Заказ успешно сохранен';
        unset($_SESSION['saleCart']);
        unset($_SESSION['cart']);
    } else {
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка внесения данных для заказа № ' . $orderId;
    }
    echo json_encode($resData);
}