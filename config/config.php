<?php

//Константы для обращения к конттроллерам
define('PathPrefix', '../controllers/');
define('PathPostfix', 'Controller.php');

//используемый шаблон
$template = 'default';
$templateAdmin = 'admin';

//пути к файламшаблонов
define('TemplatePrefix', "../views/{$template}/");
define('TemplateAdminPrefix', "../views/{$templateAdmin}/");
define('TemplatePostfix', '.tpl');

//пути к файлам шаблонов в веб пространстве
define('TemplateWebPath', "/templates/{$template}/");
define('TemplateAdminWebPath', "/templates/{$templateAdmin}/");

//инициализация шаблонизатора
require '../library/Smarty/libs/Smarty.class.php';
$smarty = new Smarty();

$smarty->setTemplateDir(TemplatePrefix);
$smarty->setCompileDir('../tmp/smarty/templates_c');
$smarty->setCacheDir('../tmp/smarty/cache');
$smarty->setConfigDir('../library/Smarty/demo/configs');

$smarty->assign('templateWebPath', TemplateWebPath);