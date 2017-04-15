<?php /* Smarty version Smarty-3.1.6, created on 2017-04-08 05:20:00
         compiled from "../views/default\user.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3098958e661ee7137b5-36597017%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '63ee73149e09ac8b024db0d49e528d996d357c0d' => 
    array (
      0 => '../views/default\\user.tpl',
      1 => 1491621573,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3098958e661ee7137b5-36597017',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58e661ee7a421',
  'variables' => 
  array (
    'arUser' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58e661ee7a421')) {function content_58e661ee7a421($_smarty_tpl) {?><h1>Ваши регистрационные данные:</h1>
<table border="0">
    <tr>
        <td>Логин</td>
        <td><?php echo $_smarty_tpl->tpl_vars['arUser']->value['email'];?>
</td>
    </tr>
    <tr>
        <td>Имя</td>
        <td><input type='text' id='newName' value='<?php echo $_smarty_tpl->tpl_vars['arUser']->value['name'];?>
'/></td>
    </tr>
    <tr>
        <td>Номер телефона</td>
        <td><input type='text' id='newPhone' value='<?php echo $_smarty_tpl->tpl_vars['arUser']->value['phone'];?>
'/></td>
    </tr>
    <tr>
        <td>Адрес</td>
        <td><textarea id='newAdress'/><?php echo $_smarty_tpl->tpl_vars['arUser']->value['adress'];?>
</textarea></td>
    </tr>
    <tr>
        <td>Новый пароль</td>
        <td><input type='password' id='newPwd1' value=''/></td>
    </tr>
    <tr>
        <td>Повторите пароль</td>
        <td><input type='password' id='newPwd2' value=''/></td>
    </tr>
    <tr>
        <td>Для сохранения данных введите текущий пароль</td>
        <td><input type='password' id='curPwd' value=''/></td>
    </td>
    <tr>
        <td>&nbsp;</td>
        <td><input type='button' value='Сохранить изменнения' onClick='updateUserData();'/></td>
    </tr>
</table><?php }} ?>