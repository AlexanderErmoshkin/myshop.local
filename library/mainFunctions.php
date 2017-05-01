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
    
    function debugOut($a) {
        echo '<br><b>' . basename( $a['file']) . '</b>'
           . "&nbsp;<font color='red'>({$a['line']})</font>"
           . "&nbsp;<font color='green'>{$a['function']}()</font>"
           . "&nbsp; -- " . dirname( $a['file']);
    }
    echo ' <pre>';
    $trace = debug_backtrace();
    array_walk($trace, 'debugOut');
    echo "\n\n";
    var_dump($value);
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
    while($row = mysqli_fetch_assoc($rs)) {
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