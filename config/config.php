<?php

//Константы для обращения к конттроллерам
define('PathPrefix', '../controllers/');
define('PathPostfix', 'Controller.php');

//используемый шаблон
$template = 'default';

//пути к файламшаблонов
define('TemplatePrefix', "../views/{$template}/");
define('TemplatePostfix', '.tpl');

//пути к файлам шаблонов в веб пространстве
define('TemplateWebPath', "/templates/{$template}/");

//инициализация шаблонизатора
require '../library/Smarty/libs/Smarty.class.php';
$smarty = new Smarty();

$smarty->setTemplateDir(TemplatePrefix);
$smarty->setCompileDir('../tmp/smarty/templates_c');
$smarty->setCacheDir('../tmp/smarty/cache');
$smarty->setConfigDir('../library/Smarty/demo/configs');

$smarty->assign('templateWebPath', TemplateWebPath);