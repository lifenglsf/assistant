<?php /* Smarty version Smarty 3.1.0, created on 2016-09-08 14:42:38
         compiled from "E:/work/assistant\tpl\common\error.html" */ ?>
<?php /*%%SmartyHeaderCode:1464957d1085405e3c6-09214188%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3fa5441fda471eee501010f19edab951d7225fe2' => 
    array (
      0 => 'E:/work/assistant\\tpl\\common\\error.html',
      1 => 1473316955,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1464957d1085405e3c6-09214188',
  'function' => 
  array (
  ),
  'version' => 'Smarty 3.1.0',
  'unifunc' => 'content_57d10854192f1',
  'variables' => 
  array (
    'message' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d10854192f1')) {function content_57d10854192f1($_smarty_tpl) {?><div class="error">
	<?php echo $_smarty_tpl->tpl_vars['message']->value;?>
	
</div><?php }} ?>