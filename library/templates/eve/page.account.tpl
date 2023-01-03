{include file="part.menu.tpl"}

<div class="mx-4 mt-2 mx-auto animate__animated animate__fadeIn">
    {if $tab == "home"}
        {if $logged}
            <h1 class="text-xl font-bold">
                <a href="logout.php" class="text-red-500 hover:text-red-300">
                    » {$lang.logout}
                </a>
            </h1>
            <p class="text-sm">{$lang.phrases.logout}</p>
            <h1 class="text-xl font-bold mt-1">
                <a href="profile.php?id={$user._id}" class="text-red-500 hover:text-red-300">
                    » {$lang.my_profile}
                </a>
            </h1>
            <p class="text-sm">{$lang.phrases.my_profile}</p>
            <h1 class="text-xl font-bold mt-1">
                <a href="mail.php?tab=inbox" class="text-red-500 hover:text-red-300">
                    » {$lang.my_mail}
                </a>
            </h1>
            <p class="text-sm">{$lang.phrases.my_mail}</p>
            <h1 class="text-xl font-bold mt-1">
                <a href="favourites.php?user={$user._id}" class="text-red-500 hover:text-red-300">
                    » {$lang.my_favourites}
                </a>
            </h1>
            <p class="text-sm">{$lang.phrases.my_favourites}</p>
        {else}
            <h1 class="text-2xl font-bold">
                {$lang.you_are_not_logged_in}
            </h1>
            <h1 class="text-xl font-bold">
                <a href="?tab=login" class="text-red-500 hover:text-red-300">
                    » {$lang.login}
                </a>
            </h1>
            <p class="text-sm">{$lang.phrases.login}</p>
            <h1 class="text-xl font-bold mt-1">
                <a href="?tab=signup" class="text-red-500 hover:text-red-300">
                    » {$lang.signup}
                </a>
            </h1>
            <p class="text-sm">{$lang.phrases.signup}</p>
        {/if}
        <h1 class="text-xl font-bold mt-1">
            <a href="favourites.php" class="text-red-500 hover:text-red-300">
                » {$lang.everyones_favourites}
            </a>
        </h1>
        <p class="text-sm">{$lang.phrases.everyones_favourites}</p>
        <h1 class="text-xl font-bold mt-1">
            <a href="?tab=options" class="text-red-500 hover:text-red-300">
                » {$lang.options}
            </a>
        </h1>
        <p class="text-sm">{$lang.phrases.options}</p>
    {elseif $tab == "login" AND !$logged}
        <h1 class="text-2xl font-bold">{$lang.login}</h1>
        <p class="text-sm">
            {$lang.phrases.login2}
            <a href="?tab=signup" class="text-red-500 hover:text-red-300">{$lang.phrases.login3}</a>
        </p>
        <form method="POST" name="login" class="mt-2">
            <label for="username">{$lang.username}:</label><br>
            <input type="text" minlength="3" maxlength="50" id="username" name="username" class="p-0 mb-1"><br>

            <label for="password">{$lang.password}:</label><br>
            <input type="password" minlength="8" maxlength="64" id="password" name="password" class="p-0"><br>

            <button type="submit" name="login"
                class="px-2 mt-1 bg-red-500 text-white hover:bg-red-800">{$lang.login}</button>

            {if isset($error)}
                <p class="mt-1"><span class="text-red-500">{$lang.error}:</span> {$error}</p>
            {/if}
        </form>

        <p class="mt-2 text-sm"><a href="account.php?tab=forgot"
                class="text-red-500 hover:text-red-300">{$lang.forgot_password}</a></p>
    {elseif $tab == "signup" AND !$logged}
        <h1 class="text-2xl font-bold">{$lang.signup}</h1>
        <form method="POST" name="signup" class="mt-2">
            <label for="username">{$lang.username}:</label><br>
            <input type="text" minlength="3" maxlength="50" id="username" name="username" class="p-0 mb-1"><br>

            <label for="password">{$lang.password}:</label><br>
            <input type="password" minlength="8" maxlength="64" id="password" name="password" class="p-0 mb-1"><br>

            <label for="password2">{$lang.repeat_password}:</label><br>
            <input type="password" minlength="8" maxlength="64" id="password2" name="password2" class="p-0 mb-1"><br>

            <label for="email">{$lang.email} ({$lang.optional}):</label><br>
            <input type="email" minlength="6" maxlength="320" id="email" name="email" class="p-0 mb-1"><br>

            <button type="submit" name="signup"
                class="px-2 mt-1 bg-red-500 text-white hover:bg-red-800">{$lang.signup}</button>

            {if isset($error)}
                <p class="mt-1"><span class="text-red-500">{$lang.error}:</span> {$error}</p>
            {/if}
        </form>
    {elseif $tab == "options"}
        <h1 class="text-2xl font-bold">{$lang.options}</h1>
        <p class="text-sm">
            {$lang.phrases.options2}
        </p>
        <form method="POST" name="updateOptions" class="mt-2">
            <label for="blacklist">{$lang.tag_blacklist}</label>
            <p class="text-sm text-gray-700">{$lang.phrases.tag_blacklist}</p>
            <textarea name="blacklist" id="blacklist"
                class="w-full md:w-[400px] min-h-[100px] px-1">{$user.blacklist}</textarea><br>

            <label for="commentThreshold">{$lang.comment_threshold}</label>
            <p class="text-sm text-gray-700">{$lang.phrases.comment_threshold}</p>
            <input type="number" id="commentThreshold" name="commentThreshold" class="p-0 mb-1 w-full md:w-[400px] px-1"
                value="{$user.commentThreshold}"><br>

            <label for="postThreshold">{$lang.post_threshold}</label>
            <p class="text-sm text-gray-700">{$lang.phrases.post_threshold}</p>
            <input type="number" id="postThreshold" name="postThreshold" class="p-0 mb-1 w-full md:w-[400px] px-1"
                value="{$user.postThreshold}"><br>

            <label for="tags">{$lang.my_tags}</label>
            <p class="text-sm text-gray-700">{$lang.phrases.my_tags}</p>
            <textarea name="tags" id="tags" class="w-full md:w-[400px] min-h-[100px] px-1">{$user.myTags}</textarea><br>

            <label>
                <input type="checkbox" name="safeOnly" id="safeOnly" {if $user.safeOnly}checked{/if}>
                {$lang.safe_only}
            </label>
            <p class="text-sm text-gray-700">{$lang.phrases.safe_only}</p>

            <button type="submit" name="updateOptions"
                class="px-2 mt-1 bg-red-500 text-white hover:bg-red-800">{$lang.save}</button>

            {if isset($error)}
                <p class="mt-1"><span class="text-red-500">{$lang.error}:</span> {$error}</p>
            {/if}
        </form>
    {/if}
</div>

{include file="part.footer.tpl"}