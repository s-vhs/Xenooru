<?php
/* Smarty version 4.3.0, created on 2023-01-03 02:31:26
  from 'C:\xamppx\htdocs\Xenooru\library\templates\eve\page.account.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63b3856e94d6c5_01361089',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '878c163f7bf2d0a124e636076a0d6da63b434133' => 
    array (
      0 => 'C:\\xamppx\\htdocs\\Xenooru\\library\\templates\\eve\\page.account.tpl',
      1 => 1672709485,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:part.menu.tpl' => 1,
    'file:part.footer.tpl' => 1,
  ),
),false)) {
function content_63b3856e94d6c5_01361089 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:part.menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="mx-4 mt-2 mx-auto animate__animated animate__fadeIn">
    <?php if ($_smarty_tpl->tpl_vars['tab']->value == "home") {?>
        <?php if ($_smarty_tpl->tpl_vars['logged']->value) {?>
            <h1 class="text-xl font-bold">
                <a href="logout.php" class="text-red-500 hover:text-red-300">
                    » <?php echo $_smarty_tpl->tpl_vars['lang']->value['logout'];?>

                </a>
            </h1>
            <p class="text-sm"><?php echo $_smarty_tpl->tpl_vars['lang']->value['phrases']['logout'];?>
</p>
            <h1 class="text-xl font-bold mt-1">
                <a href="profile.php?id=<?php echo $_smarty_tpl->tpl_vars['user']->value['_id'];?>
" class="text-red-500 hover:text-red-300">
                    » <?php echo $_smarty_tpl->tpl_vars['lang']->value['my_profile'];?>

                </a>
            </h1>
            <p class="text-sm"><?php echo $_smarty_tpl->tpl_vars['lang']->value['phrases']['my_profile'];?>
</p>
            <h1 class="text-xl font-bold mt-1">
                <a href="mail.php?tab=inbox" class="text-red-500 hover:text-red-300">
                    » <?php echo $_smarty_tpl->tpl_vars['lang']->value['my_mail'];?>

                </a>
            </h1>
            <p class="text-sm"><?php echo $_smarty_tpl->tpl_vars['lang']->value['phrases']['my_mail'];?>
</p>
            <h1 class="text-xl font-bold mt-1">
                <a href="favourites.php?user=<?php echo $_smarty_tpl->tpl_vars['user']->value['_id'];?>
" class="text-red-500 hover:text-red-300">
                    » <?php echo $_smarty_tpl->tpl_vars['lang']->value['my_favourites'];?>

                </a>
            </h1>
            <p class="text-sm"><?php echo $_smarty_tpl->tpl_vars['lang']->value['phrases']['my_favourites'];?>
</p>
        <?php } else { ?>
            <h1 class="text-2xl font-bold">
                <?php echo $_smarty_tpl->tpl_vars['lang']->value['you_are_not_logged_in'];?>

            </h1>
            <h1 class="text-xl font-bold">
                <a href="?tab=login" class="text-red-500 hover:text-red-300">
                    » <?php echo $_smarty_tpl->tpl_vars['lang']->value['login'];?>

                </a>
            </h1>
            <p class="text-sm"><?php echo $_smarty_tpl->tpl_vars['lang']->value['phrases']['login'];?>
</p>
            <h1 class="text-xl font-bold mt-1">
                <a href="?tab=signup" class="text-red-500 hover:text-red-300">
                    » <?php echo $_smarty_tpl->tpl_vars['lang']->value['signup'];?>

                </a>
            </h1>
            <p class="text-sm"><?php echo $_smarty_tpl->tpl_vars['lang']->value['phrases']['signup'];?>
</p>
        <?php }?>
        <h1 class="text-xl font-bold mt-1">
            <a href="favourites.php" class="text-red-500 hover:text-red-300">
                » <?php echo $_smarty_tpl->tpl_vars['lang']->value['everyones_favourites'];?>

            </a>
        </h1>
        <p class="text-sm"><?php echo $_smarty_tpl->tpl_vars['lang']->value['phrases']['everyones_favourites'];?>
</p>
        <h1 class="text-xl font-bold mt-1">
            <a href="?tab=options" class="text-red-500 hover:text-red-300">
                » <?php echo $_smarty_tpl->tpl_vars['lang']->value['options'];?>

            </a>
        </h1>
        <p class="text-sm"><?php echo $_smarty_tpl->tpl_vars['lang']->value['phrases']['options'];?>
</p>
    <?php } elseif ($_smarty_tpl->tpl_vars['tab']->value == "login" && !$_smarty_tpl->tpl_vars['logged']->value) {?>
        <h1 class="text-xl font-bold"><?php echo $_smarty_tpl->tpl_vars['lang']->value['login'];?>
</h1>
        <p class="text-sm">
            <?php echo $_smarty_tpl->tpl_vars['lang']->value['phrases']['login2'];?>

            <a href="?tab=signup" class="text-red-500 hover:text-red-300"><?php echo $_smarty_tpl->tpl_vars['lang']->value['phrases']['login3'];?>
</a>
        </p>
        <form method="POST" name="login" class="mt-2">
            <label for="username"><?php echo $_smarty_tpl->tpl_vars['lang']->value['username'];?>
:</label><br>
            <input type="text" minlength="3" maxlength="50" id="username" name="username" class="p-0 mb-1"><br>

            <label for="password"><?php echo $_smarty_tpl->tpl_vars['lang']->value['password'];?>
:</label><br>
            <input type="password" minlength="8" maxlength="64" id="password" name="password" class="p-0"><br>

            <button type="submit" name="login"
                class="px-2 mt-1 bg-red-500 text-white hover:bg-red-800"><?php echo $_smarty_tpl->tpl_vars['lang']->value['login'];?>
</button>

            <?php if ((isset($_smarty_tpl->tpl_vars['error']->value))) {?>
                <p class="mt-1"><span class="text-red-500"><?php echo $_smarty_tpl->tpl_vars['lang']->value['error'];?>
:</span> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</p>
            <?php }?>
        </form>

        <p class="mt-2 text-sm"><a href="account.php?tab=forgot"
                class="text-red-500 hover:text-red-300"><?php echo $_smarty_tpl->tpl_vars['lang']->value['forgot_password'];?>
</a></p>
    <?php } elseif ($_smarty_tpl->tpl_vars['tab']->value == "signup" && !$_smarty_tpl->tpl_vars['logged']->value) {?>
        <h1 class="text-xl font-bold"><?php echo $_smarty_tpl->tpl_vars['lang']->value['signup'];?>
</h1>
        <form method="POST" name="signup" class="mt-2">
            <label for="username"><?php echo $_smarty_tpl->tpl_vars['lang']->value['username'];?>
:</label><br>
            <input type="text" minlength="3" maxlength="50" id="username" name="username" class="p-0 mb-1"><br>

            <label for="password"><?php echo $_smarty_tpl->tpl_vars['lang']->value['password'];?>
:</label><br>
            <input type="password" minlength="8" maxlength="64" id="password" name="password" class="p-0 mb-1"><br>

            <label for="password2"><?php echo $_smarty_tpl->tpl_vars['lang']->value['repeat_password'];?>
:</label><br>
            <input type="password" minlength="8" maxlength="64" id="password2" name="password2" class="p-0 mb-1"><br>

            <label for="email"><?php echo $_smarty_tpl->tpl_vars['lang']->value['email'];?>
 (<?php echo $_smarty_tpl->tpl_vars['lang']->value['optional'];?>
):</label><br>
            <input type="email" minlength="6" maxlength="320" id="email" name="email" class="p-0 mb-1"><br>

            <button type="submit" name="signup"
                class="px-2 mt-1 bg-red-500 text-white hover:bg-red-800"><?php echo $_smarty_tpl->tpl_vars['lang']->value['signup'];?>
</button>

            <?php if ((isset($_smarty_tpl->tpl_vars['error']->value))) {?>
                <p class="mt-1"><span class="text-red-500"><?php echo $_smarty_tpl->tpl_vars['lang']->value['error'];?>
:</span> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</p>
            <?php }?>
        </form>
    <?php } elseif ($_smarty_tpl->tpl_vars['tab']->value == "options") {?>
        <h1 class="text-xl font-bold"><?php echo $_smarty_tpl->tpl_vars['lang']->value['options'];?>
</h1>
        <p class="text-sm">
            <?php echo $_smarty_tpl->tpl_vars['lang']->value['phrases']['options2'];?>

        </p>
        <form method="POST" name="updateOptions" class="mt-2">
            <label for="blacklist"><?php echo $_smarty_tpl->tpl_vars['lang']->value['tag_blacklist'];?>
</label>
            <p class="text-sm text-gray-700"><?php echo $_smarty_tpl->tpl_vars['lang']->value['phrases']['tag_blacklist'];?>
</p>
            <textarea name="blacklist" id="blacklist"
                class="w-full md:w-[400px] min-h-[100px]"><?php echo $_smarty_tpl->tpl_vars['user']->value['blacklist'];?>
</textarea><br>

            <label for="commentThreshold"><?php echo $_smarty_tpl->tpl_vars['lang']->value['comment_threshold'];?>
</label>
            <p class="text-sm text-gray-700"><?php echo $_smarty_tpl->tpl_vars['lang']->value['phrases']['comment_threshold'];?>
</p>
            <input type="number" id="commentThreshold" name="commentThreshold" class="p-0 mb-1 w-full md:w-[400px]"
                value="<?php echo $_smarty_tpl->tpl_vars['user']->value['commentThreshold'];?>
"><br>

            <label for="postThreshold"><?php echo $_smarty_tpl->tpl_vars['lang']->value['post_threshold'];?>
</label>
            <p class="text-sm text-gray-700"><?php echo $_smarty_tpl->tpl_vars['lang']->value['phrases']['post_threshold'];?>
</p>
            <input type="number" id="postThreshold" name="postThreshold" class="p-0 mb-1 w-full md:w-[400px]"
                value="<?php echo $_smarty_tpl->tpl_vars['user']->value['postThreshold'];?>
"><br>

            <label for="tags"><?php echo $_smarty_tpl->tpl_vars['lang']->value['my_tags'];?>
</label>
            <p class="text-sm text-gray-700"><?php echo $_smarty_tpl->tpl_vars['lang']->value['phrases']['my_tags'];?>
</p>
            <textarea name="tags" id="tags" class="w-full md:w-[400px] min-h-[100px]"><?php echo $_smarty_tpl->tpl_vars['user']->value['myTags'];?>
</textarea><br>

            <label>
                <input type="checkbox" name="safeOnly" id="safeOnly" <?php if ($_smarty_tpl->tpl_vars['user']->value['safeOnly']) {?>checked<?php }?>>
                <?php echo $_smarty_tpl->tpl_vars['lang']->value['safe_only'];?>

            </label>
            <p class="text-sm text-gray-700"><?php echo $_smarty_tpl->tpl_vars['lang']->value['phrases']['safe_only'];?>
</p>

            <button type="submit" name="updateOptions"
                class="px-2 mt-1 bg-red-500 text-white hover:bg-red-800"><?php echo $_smarty_tpl->tpl_vars['lang']->value['save'];?>
</button>

            <?php if ((isset($_smarty_tpl->tpl_vars['error']->value))) {?>
                <p class="mt-1"><span class="text-red-500"><?php echo $_smarty_tpl->tpl_vars['lang']->value['error'];?>
:</span> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</p>
            <?php }?>
        </form>
    <?php }?>
</div>

<?php $_smarty_tpl->_subTemplateRender("file:part.footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
