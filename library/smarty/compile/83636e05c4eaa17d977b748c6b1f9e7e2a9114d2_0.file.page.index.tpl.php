<?php
/* Smarty version 4.3.0, created on 2023-01-03 00:37:07
  from 'C:\xamppx\htdocs\Xenooru\library\templates\eve\page.index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63b36aa345baf3_26366541',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '83636e05c4eaa17d977b748c6b1f9e7e2a9114d2' => 
    array (
      0 => 'C:\\xamppx\\htdocs\\Xenooru\\library\\templates\\eve\\page.index.tpl',
      1 => 1672702625,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63b36aa345baf3_26366541 (Smarty_Internal_Template $_smarty_tpl) {
?><div>
    <a href="browse.php">
        <img src="<?php echo $_smarty_tpl->tpl_vars['config']->value['logo'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['lang']->value['logo'];?>
" class="w-full animate__animated animate__fadeInDown">
    </a>
    <p class="text-center animate__animated animate__fadeInUp">
        <a href="browse.php" class="mx-2 text-red-500 hover:text-red-300"><?php echo $_smarty_tpl->tpl_vars['lang']->value['browse'];?>
</a>
        <a href="comments.php" class="mx-2 text-red-500 hover:text-red-300"><?php echo $_smarty_tpl->tpl_vars['lang']->value['comments'];?>
</a>
        <a href="account.php" class="mx-2 text-red-500 hover:text-red-300"><?php echo $_smarty_tpl->tpl_vars['lang']->value['my_account'];?>
</a>
        <a href="forums.php" class="mx-2 text-red-500 hover:text-red-300"><?php echo $_smarty_tpl->tpl_vars['lang']->value['forums'];?>
</a>
    </p>
    <form method="GET" name="search" action="browse.php">
        <div class="flex items-center">
            <input type="text" name="query" class="mx-auto mt-1 p-0 w-[350px] animate__animated animate__fadeInUp">
        </div>
        <div class="flex items-center">
            <input type="submit"
                class="mx-auto border border-black bg-gray-300 mt-1 px-2 hover:bg-gray-400 cursor-pointer animate__animated animate__fadeInUp"
                value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['search'];?>
">
        </div>
    </form>
    <div class="mt-1">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, 'totalposts', 'array', false, 'id');
$_smarty_tpl->tpl_vars['array']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['id']->value => $_smarty_tpl->tpl_vars['array']->value) {
$_smarty_tpl->tpl_vars['array']->do_else = false;
?>
            <img src="assets/counter/<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
.gif" class="mx-auto animate__animated animate__zoomIn">
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </div>
    <p class="mt-1 text-center text-gray-500 text-sm animate__animated animate__fadeInDown">
        <a href="https://github.com/s-vhs/Xenooru" target="_blank">
            <?php echo $_smarty_tpl->tpl_vars['lang']->value['running_xenooru'];?>
 <?php echo $_smarty_tpl->tpl_vars['version']->value;?>

        </a>
    </p>
</div><?php }
}
