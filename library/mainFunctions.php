<?php
/**
 * Формирование запрашиваемой страницы
 * @param string $controllerName название контроллера
 * @param string $actionName название исполняемой функции
 */
function load_page($smarty, $controllerName, $actionName = 'index') {
    include_once PathPrefix . $controllerName . PathPostfix;
    
    $function = $actionName . 'Action';
    $function($smarty);
}

/**
 * загрузка шаблона
 * @param object $smarty объект шаблонизатора
 * @param string $templateName название файла шаблона
 */
function loadTemplate($smarty, $templateName) {
    $smarty->display($templateName . TemplatePostfix);
}

/**
 * функция отладки. Останавливает работу программы выводя значение
 * переменной $value
 * @param variant $value переменная для вывода ее на страницу
 */
function d($value = NULL, $die = 1) {
    echo 'Debug: <br /><pre>';
    print_r($value);
    echo '</pre>';
    
    if ($die) die;
}

/**
 * Преобразование результата работы функции выборки в ассоциативный массив
 * @param recordset $rs набор строк - результат SELECT
 * @return array
 */
function createSmartyArray($rs) {
    if (! $rs) return false;
    
    $smartyRs = array();
    while($row = mysql_fetch_assoc($rs)) {
        $smartyRs[] = $row;
    }
    
    return $smartyRs;
}

/**
 * реддирект
 * @param string $url адрес для перенаправления
 */
function redirect($url='/') {
    header("Location: ".$url);
    exit();
}