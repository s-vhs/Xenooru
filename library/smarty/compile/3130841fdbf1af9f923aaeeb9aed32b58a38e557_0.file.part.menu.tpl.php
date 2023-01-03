<?php
/* Smarty version 4.3.0, created on 2023-01-03 00:36:29
  from 'C:\xamppx\htdocs\Xenooru\library\templates\eve\part.menu.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63b36a7dd76128_81983543',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3130841fdbf1af9f923aaeeb9aed32b58a38e557' => 
    array (
      0 => 'C:\\xamppx\\htdocs\\Xenooru\\library\\templates\\eve\\part.menu.tpl',
      1 => 1672702589,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63b36a7dd76128_81983543 (Smarty_Internal_Template $_smarty_tpl) {
?><nav class="bg-white border-gray-200">
    <div class="flex flex-wrap justify-between items-center mx-auto px-4 py-2">
        <a href="index.php" class="flex items-center text-red-500 hover:text-red-300">
            <span
                class="self-center text-xl font-bold whitespace-nowrap animate__animated animate__tada"><?php echo $_smarty_tpl->tpl_vars['config']->value['title'];?>
</span>
        </a>
    </div>
</nav>
<nav>
    <div class="px-4 mx-auto">
        <div class="flex items-center">
            <ul class="flex flex-row mt-0 space-x-1 text-sm font-medium">
                <li>
                    <a href="account.php"
                        class="<?php if ($_smarty_tpl->tpl_vars['pages']->value['isAccount']) {?>text-white bg-red-500 font-bold<?php } else { ?>text-red-500 hover:text-red-300<?php }?> p-1"><?php echo $_smarty_tpl->tpl_vars['lang']->value['my_account'];?>
</a>
                </li>
                <li>
                    <a href="browse.php"
                        class="<?php if ($_smarty_tpl->tpl_vars['pages']->value['isBrowse']) {?>text-white bg-red-500 font-bold<?php } else { ?>text-red-500 hover:text-red-300<?php }?> p-1"><?php echo $_smarty_tpl->tpl_vars['lang']->value['posts'];?>
</a>
                </li>
                <li>
                    <a href="comments.php"
                        class="<?php if ($_smarty_tpl->tpl_vars['pages']->value['isComments']) {?>text-white bg-red-500 font-bold<?php } else { ?>text-red-500 hover:text-red-300<?php }?> p-1"><?php echo $_smarty_tpl->tpl_vars['lang']->value['comments'];?>
</a>
                </li>
                <li>
                    <a href="tags.php"
                        class="<?php if ($_smarty_tpl->tpl_vars['pages']->value['isTags']) {?>text-white bg-red-500 font-bold<?php } else { ?>text-red-500 hover:text-red-300<?php }?> p-1"><?php echo $_smarty_tpl->tpl_vars['lang']->value['tags'];?>
</a>
                </li>
                <li>
                    <a href="forums.php"
                        class="<?php if ($_smarty_tpl->tpl_vars['pages']->value['isForums']) {?>text-white bg-red-500 font-bold<?php } else { ?>text-red-500 hover:text-red-300<?php }?> p-1"><?php echo $_smarty_tpl->tpl_vars['lang']->value['forums'];?>
</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<nav>
    <div class="bg-red-500 text-white p-1 px-4">
        <div class="flex items-center">
            <ul class="flex flex-row mt-0 space-x-1 text-sm font-medium">
                <?php if ($_smarty_tpl->tpl_vars['pages']->value['isAccount']) {?>
                    <li>
                        <a href="account.php" class="mx-1 hover:text-red-200"><?php echo $_smarty_tpl->tpl_vars['lang']->value['home'];?>
</a>
                    </li>
                    <?php if ($_smarty_tpl->tpl_vars['logged']->value) {?>
                        <li>
                            <a href="logout.php" class="mx-1 hover:text-red-200"><?php echo $_smarty_tpl->tpl_vars['lang']->value['logout'];?>
</a>
                        </li>
                        <li>
                            <a href="profile.php?id=<?php echo $_smarty_tpl->tpl_vars['user']->value['_id'];?>
" class="mx-1 hover:text-red-200"><?php echo $_smarty_tpl->tpl_vars['lang']->value['my_profile'];?>
</a>
                        </li>
                        <li>
                            <a href="mail.php?tab=inbox" class="mx-1 hover:text-red-200"><?php echo $_smarty_tpl->tpl_vars['lang']->value['my_mail'];?>
</a>
                        </li>
                        <li>
                            <a href="favourites.php?user=<?php echo $_smarty_tpl->tpl_vars['user']->value['_id'];?>
" class="mx-1 hover:text-red-200"><?php echo $_smarty_tpl->tpl_vars['lang']->value['my_favourites'];?>
</a>
                        </li>
                    <?php } else { ?>
                        <li>
                            <a href="account.php?tab=login" class="mx-1 hover:text-red-200"><?php echo $_smarty_tpl->tpl_vars['lang']->value['login'];?>
</a>
                        </li>
                        <li>
                            <a href="account.php?tab=signup" class="mx-1 hover:text-red-200"><?php echo $_smarty_tpl->tpl_vars['lang']->value['signup'];?>
</a>
                        </li>
                    <?php }?>
                    <li>
                        <a href="favourites.php" class="mx-1 hover:text-red-200"><?php echo $_smarty_tpl->tpl_vars['lang']->value['everyones_favourites'];?>
</a>
                    </li>
                    <li>
                        <a href="account.php?tab=options" class="mx-1 hover:text-red-200"><?php echo $_smarty_tpl->tpl_vars['lang']->value['options'];?>
</a>
                    </li>
                <?php }?>
            </ul>
        </div>
    </div>
</nav><?php }
}
