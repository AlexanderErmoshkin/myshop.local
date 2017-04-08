<?php

session_start();

if (! isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

include_once '../config/config.php'; //загрузка настроек
include_once '../config/db.php'; //загрузка бд
include_once '../library/mainFunctions.php'; //основные функции
//определяем имя контроллера
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) : 'Index';

//определяем имя функции
$actionName = isset($_GET['action']) ? $_GET['action'] : 'Index';

//если сессия содержит данные о зарегистрированном пользователе
//передаем их в шаблон
if (isset($_SESSION['user'])) {
    $smarty->assign('arUser', $_SESSION['user']);
}

//инициализация переменной шаблонизатора количество элементов в корзине
$smarty->assign('cartCntItems', count($_SESSION['cart']));

load_page($smarty, $controllerName, $actionName);