<nav class="bg-white border-gray-200">
    <div class="flex flex-wrap justify-between items-center mx-auto px-4 py-2">
        <a href="index.php" class="flex items-center text-red-500 hover:text-red-300">
            <span
                class="self-center text-xl font-bold whitespace-nowrap animate__animated animate__tada">{$config.title}</span>
        </a>
    </div>
</nav>
<nav>
    <div class="px-4 mx-auto">
        <div class="flex items-center">
            <ul class="flex flex-row mt-0 space-x-1 text-sm font-medium">
                <li>
                    <a href="account.php"
                        class="{if $pages.isAccount}text-white bg-red-500 font-bold{else}text-red-500 hover:text-red-300{/if} p-1">{$lang.my_account}</a>
                </li>
                <li>
                    <a href="browse.php"
                        class="{if $pages.isBrowse}text-white bg-red-500 font-bold{else}text-red-500 hover:text-red-300{/if} p-1">{$lang.posts}</a>
                </li>
                <li>
                    <a href="comments.php"
                        class="{if $pages.isComments}text-white bg-red-500 font-bold{else}text-red-500 hover:text-red-300{/if} p-1">{$lang.comments}</a>
                </li>
                <li>
                    <a href="tags.php"
                        class="{if $pages.isTags}text-white bg-red-500 font-bold{else}text-red-500 hover:text-red-300{/if} p-1">{$lang.tags}</a>
                </li>
                <li>
                    <a href="forums.php"
                        class="{if $pages.isForums}text-white bg-red-500 font-bold{else}text-red-500 hover:text-red-300{/if} p-1">{$lang.forums}</a>
                </li>
                <li>
                    <a href="wiki.php"
                        class="{if $pages.isWiki}text-white bg-red-500 font-bold{else}text-red-500 hover:text-red-300{/if} p-1">{$lang.wiki}</a>
                </li>
                <li>
                    <a href="more.php"
                        class="{if $pages.isMore}text-white bg-red-500 font-bold{else}text-red-500 hover:text-red-300{/if} p-1">{$lang.more}</a>
                </li>
                {if $logged && $userlevel.perms.can_manage_reports}
                    <li>
                        <a href="admin.php"
                            class="{if $pages.isAdmin}text-white bg-red-500 font-bold{else}text-red-500 hover:text-red-300{/if} p-1">{$lang.admin}</a>
                    </li>
                {/if}
            </ul>
        </div>
    </div>
</nav>
<nav>
    <div class="bg-red-500 text-white p-1 px-4">
        <div class="flex items-center">
            <ul class="flex flex-row mt-0 space-x-1 text-sm font-medium">
                {if $pages.isAccount}
                    <li>
                        <a href="account.php" class="mx-1 hover:text-red-200">{$lang.home}</a>
                    </li>
                    {if $logged}
                        <li>
                            <a href="logout.php" class="mx-1 hover:text-red-200">{$lang.logout}</a>
                        </li>
                        <li>
                            <a href="profile.php?id={$user._id}" class="mx-1 hover:text-red-200">{$lang.my_profile}</a>
                        </li>
                        <li>
                            <a href="mail.php?tab=inbox" class="mx-1 hover:text-red-200">{$lang.my_mail}</a>
                        </li>
                        <li>
                            <a href="browse.php?page=favourites&user={$user._id}"
                                class="mx-1 hover:text-red-200">{$lang.my_favourites}</a>
                        </li>
                    {else}
                        <li>
                            <a href="account.php?tab=login" class="mx-1 hover:text-red-200">{$lang.login}</a>
                        </li>
                        <li>
                            <a href="account.php?tab=signup" class="mx-1 hover:text-red-200">{$lang.signup}</a>
                        </li>
                    {/if}
                    <li>
                        <a href="users.php" class="mx-1 hover:text-red-200">{$lang.everyones_favourites}</a>
                    </li>
                    <li>
                        <a href="account.php?tab=options" class="mx-1 hover:text-red-200">{$lang.options}</a>
                    </li>
                {elseif $pages.isBrowse}
                    <li>
                        <a href="browse.php" class="mx-1 hover:text-red-200">{$lang.list}</a>
                    </li>
                    <li>
                        <a href="upload.php" class="mx-1 hover:text-red-200">{$lang.upload}</a>
                    </li>
                    {if $logged}
                        <li>
                            <a href="browse.php?page=favourites&user={$user._id}"
                                class="mx-1 hover:text-red-200">{$lang.my_favourites}</a>
                        </li>
                    {/if}
                    <li>
                        <a href="?page=random" class="mx-1 hover:text-red-200">{$lang.random}</a>
                    </li>
                {elseif $pages.isWiki}
                    <li>
                        <a href="wiki.php" class="mx-1 hover:text-red-200">{$lang.all_terms}</a>
                    </li>
                {elseif $pages.isMore}
                    <li>
                        <a href="more.php" class="mx-1 hover:text-red-200">{$lang.home}</a>
                    </li>
                    {if !empty($config.email.general)}
                        <li>
                            <a href="mailto:{$config.email.general}" class="mx-1 hover:text-red-200"
                                target="_blank">{$lang.contact_us}</a>
                        </li>
                    {/if}
                    <li>
                        <a href="?tab=about" class="mx-1 hover:text-red-200">{$lang.about}</a>
                    </li>
                    <li>
                        <a href="?tab=help" class="mx-1 hover:text-red-200">{$lang.help}</a>
                    </li>
                    <li>
                        <a href="?tab=tos" class="mx-1 hover:text-red-200">{$lang.tos}</a>
                    </li>
                    <li>
                        <a href="?tab=privacy" class="mx-1 hover:text-red-200">{$lang.privacy_policy}</a>
                    </li>
                {elseif $pages.isAdmin}
                    <li>
                        <a href="?tab=home" class="mx-1 hover:text-red-200">{$lang.home}</a>
                    </li>
                    <li>
                        <a href="?tab=aqueue" class="mx-1 hover:text-red-200">{$lang.approval_queue}</a>
                    </li>
                    <li>
                        <a href="?tab=creports" class="mx-1 hover:text-red-200">{$lang.comment_reports}</a>
                    </li>
                    <li>
                        <a href="?tab=preports" class="mx-1 hover:text-red-200">{$lang.post_reports}</a>
                    </li>
                {/if}
            </ul>
        </div>
    </div>
</nav>