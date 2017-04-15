<?php /* Smarty version Smarty-3.1.6, created on 2017-04-15 08:03:08
         compiled from "../views/default\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1677158f1b79c542f67-23102239%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9797888b337e03f99b06385b60a372bbb52d5e02' => 
    array (
      0 => '../views/default\\header.tpl',
      1 => 1490799258,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1677158f1b79c542f67-23102239',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'PageTitle' => 0,
    'templateWebPath' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f1b79c6e96b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f1b79c6e96b')) {function content_58f1b79c6e96b($_smarty_tpl) {?><html>
    <head>
        <title><?php echo $_smarty_tpl->tpl_vars['PageTitle']->value;?>
</title>
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['templateWebPath']->value;?>
css/main.css" type="text/css"/>
        <script type="text/javascript" src="/js/jquery-3.2.0.min.js"></script>
        <script type="text/javascript" src="/js/main.js"></script>
    </head>
    <body>
        <div id="header">
            <h1>my shop - интернет магазин</h1>
        </div>
        
        
        <?php echo $_smarty_tpl->getSubTemplate ('leftcolumn.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        
        <div id="centerColumn">
            <?php }} ?>