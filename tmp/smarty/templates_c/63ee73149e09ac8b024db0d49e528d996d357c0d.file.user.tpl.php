<?php /* Smarty version Smarty-3.1.6, created on 2017-04-15 10:08:41
         compiled from "../views/default\user.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1720958f1b79c9ee448-92507769%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '63ee73149e09ac8b024db0d49e528d996d357c0d' => 
    array (
      0 => '../views/default\\user.tpl',
      1 => 1492243718,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1720958f1b79c9ee448-92507769',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f1b79ca3686',
  'variables' => 
  array (
    'arUser' => 0,
    'rsUserOrders' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f1b79ca3686')) {function content_58f1b79ca3686($_smarty_tpl) {?><h1>Ваши регистрационные данные:</h1>
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
</table>
    
<h2>Заказы:</h2>
<?php if (!$_smarty_tpl->tpl_vars['rsUserOrders']->value){?>
    Нет заказов
<?php }else{ ?>
    <table border='1' cellpadding='1' cellspacing='1'>
        <tr>
            <th>№</th>
            <th>Действие</th>
            <th>ID заказа</th>
            <th>Статус</th>
            <th>Дата создания</th>
            <th>Дата оплаты</th>
            <th>Дополнительная информация</th>
        </tr>
        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rsUserOrders']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['orders']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['orders']['iteration']++;
?>
            <tr>
                <td><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['orders']['iteration'];?>
</td>
                <td><a href="#" onclick="showProducts('<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
'); return false;">Показать товар заказа</a></td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['status'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['date_created'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['date_payment'];?>
&nbsp;</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['comment'];?>
</td>
            </tr>
        <?php } ?>    
    </table>
<?php }?>
<?php }} ?>