{include file="part.menu.tpl"}

<div class="grid grid-cols-8 gap-2 mx-4 mt-2">
    <div class="col-span-1">
        <form method="GET" name="search" action="browse.php">
            <input type="text" name="page" value="search" hidden readonly>
            <label for="search" class="text-sm">{$lang.search}:</label>
            <input onkeyup="doSearch('search', 'display')" type="text" name="query"
                class="mx-auto px-1 text-sm p-0 w-full" id="search" value="{if isset($searchquery)}{$searchquery}{/if}">
            <div id="display" class="w-full"></div>
            <button type="submit"
                class="text-sm text-center bg-red-500 hover:bg-red-300 w-full text-white">{$lang.search}</button>
        </form>
        {if $page == "browse" || $page == "search"}
            <p class="font-bold mt-2">{$lang.tags}</p>
            <ul class="text-sm">
                <!-- Copyrights Block start -->
                {if !empty($tags.copyrights)}
                    <li class="font-bold">{$lang.copyrights}</li>
                    {foreach from=$tags.copyrights item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="?page=search&query={$item.full}" class="text-fuchsia-500 hover:text-red-300">{$item.name}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Copyrights block end -->
                <!-- Characters Block start -->
                {if !empty($tags.characters)}
                    <li class="font-bold">{$lang.characters}</li>
                    {foreach from=$tags.characters item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="?page=search&query={$item.full}"
                                class="text-lime-500 hover:text-red-300">{str_replace("_", " ", $item.name)}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Characters block end -->
                <!-- Artists Block start -->
                {if !empty($tags.artists)}
                    <li class="font-bold">{$lang.artists}</li>
                    {foreach from=$tags.artists item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="?page=search&query={$item.full}"
                                class="text-indigo-500 hover:text-red-300">{str_replace("_", " ", $item.name)}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Artists block end -->
                <!-- Tags Block start -->
                {if !empty($tags.tags)}
                    <li class="font-bold">{$lang.general}</li>
                    {foreach from=$tags.tags item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="?page=search&query={$item.full}"
                                class="text-red-500 hover:text-red-300">{str_replace("_", " ", $item.name)}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Tags block end -->
                <!-- Metas Block start -->
                {if !empty($tags.metas)}
                    <li class="font-bold">{$lang.metas}</li>
                    {foreach from=$tags.metas item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="?page=search&query={$item.full}"
                                class="text-orange-500 hover:text-red-300">{str_replace("_", " ", $item.name)}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Metas block end -->
            </ul>
        {elseif $page == "post"}
            <p class="font-bold mt-2">{$lang.tags}</p>
            <ul class="text-sm">
                <!-- Copyrights Block start -->
                {if !empty($tags.copyrights)}
                    <li class="font-bold">{$lang.copyrights}</li>
                    {foreach from=$tags.copyrights item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="?page=search&query={$item.full}" class="text-fuchsia-500 hover:text-red-300">{$item.name}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Copyrights block end -->
                <!-- Characters Block start -->
                {if !empty($tags.characters)}
                    <li class="font-bold">{$lang.characters}</li>
                    {foreach from=$tags.characters item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="?page=search&query={$item.full}"
                                class="text-lime-500 hover:text-red-300">{str_replace("_", " ", $item.name)}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Characters block end -->
                <!-- Artists Block start -->
                {if !empty($tags.artists)}
                    <li class="font-bold">{$lang.artists}</li>
                    {foreach from=$tags.artists item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="?page=search&query={$item.full}"
                                class="text-indigo-500 hover:text-red-300">{str_replace("_", " ", $item.name)}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Artists block end -->
                <!-- Tags Block start -->
                {if !empty($tags.tags)}
                    <li class="font-bold">{$lang.general}</li>
                    {foreach from=$tags.tags item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="?page=search&query={$item.full}"
                                class="text-red-500 hover:text-red-300">{str_replace("_", " ", $item.name)}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Tags block end -->
                <!-- Metas Block start -->
                {if !empty($tags.metas)}
                    <li class="font-bold">{$lang.metas}</li>
                    {foreach from=$tags.metas item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="?page=search&query={$item.full}"
                                class="text-orange-500 hover:text-red-300">{str_replace("_", " ", $item.name)}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Metas block end -->
            </ul>
            <p class="font-bold mt-2">{$lang.statistics}</p>
            <ul class="text-sm">
                <li>{$lang.id}: {$post._id}</li>
                <li>{$lang.posted}: {$post.timestamp}</li>
                <li>{$lang.by} <a href="profile.php?id={$poster._id}"
                        class="text-red-500 hover:text-red-300">{$poster.username}</a></li>
                <li>{$lang.dimensions}: {$post.file.dimensions}</li>
                <li>{$lang.size}: {formatBytes($post.file.size)}</li>
                {if !empty($post.source)}
                    <lil>{$lang.source}: <a href="{$post.source}" target="_blank"
                            class="text-red-500 hover:text-red-300">{$lang.visit}</a></lil>
                {/if}
                <li>{$lang.rating}: {ucfirst($post.rating)}</li>
                <li>{$lang.score}:
                    <span id="scoreCount">{$post.score}</span>
                    {if $userlevel.perms.can_vote_post}({$lang.vote}
                        <span class="text-red-500 hover:text-red-300 cursor-pointer"
                            onclick="votePostUp({$post._id})">{$lang.up}</span>/<span
                            class="text-red-500 hover:text-red-300 cursor-pointer"
                            onclick="votePostDown({$post._id})">{$lang.down}</span>)
                    {/if}
                </li>
                <li id="voteDiv" class="italic text-red-500"></li>
            </ul>
            <p class="font-bold mt-2">{$lang.options}</p>
            <ul class="text-sm">
                {if $userlevel.perms.can_edit_post && !$post.deleted}
                    <li><span class="text-red-500 hover:text-red-300 cursor-pointer"
                            onclick="toggleDiv('editDiv');">{$lang.edit}</span></li>
                {/if}
                <li class="font-bold"><a href="{$config.db.uploads.0}/{$post.file.database.file}" target="_blank"
                        class="text-red-500 hover:text-red-300">{$lang.original_image}</a></li>
                {if $userlevel.perms.can_delete_post || ($logged && $user._id == $poster._id)}
                    <li>{$lang.delete}</li>
                {/if}
                {if $userlevel.perms.can_report}
                    <li>{$lang.flag_for_deletion}</li>
                {/if}
                {if $userlevel.perms.can_manage_favourites}
                    {if $favourited}
                        <li id="favouriteText" class="cursor-pointer text-red-500 hover:text-red-300"
                            onclick="removeFromFavs({$post._id})">{$lang.remove_from_favourites}
                        </li>
                    {else}
                        <li id="favouriteText" class="cursor-pointer text-red-500 hover:text-red-300"
                            onclick="addToFavs({$post._id})">{$lang.add_to_favourites}</li>
                    {/if}
                {/if}
            </ul>

            <p class="font-bold mt-2">{$lang.history}</p>
            <ul class="text-sm">
                <li><a href="logs.php?page=post&id={$post._id}" class="text-red-500 hover:text-red-300">{$lang.tags}</a>
                </li>
            </ul>

            <p class="font-bold mt-2">{$lang.related_posts}</p>
            <ul class="text-sm">
                <li><a href="https://saucenao.com/search.php?url={$url}{$config.db.uploads.0}/{$post.file.database.file}"
                        class="text-red-500 hover:text-red-300" target="_blank">{$lang.saucenao}</a></li>
                <li><a href="https://iqdb.org/?url={$url}{$config.db.uploads.0}/{$post.file.database.file}"
                        class="text-red-500 hover:text-red-300" target="_blank">{$lang.iqdb}</a></li>
                <li><a href="https://waifu2x.booru.pics/Home/fromlink?denoise=1&scale=2&url={$url}{$config.db.uploads.0}/{$post.file.database.file}"
                        class="text-red-500 hover:text-red-300" target="_blank">{$lang.waifu2x}</a></li>
            </ul>
        {/if}
        <!-- Chibi start -->
        <img src="assets/{$theme.directory}/{$config.chibi}" class="mt-2 w-full" alt="Chibi!">
        <!-- Chibi end -->
    </div>
    <div class="col-span-7">
        {if $page != "post"}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4">
                {if $page == "browse" || $page == "search"}
                    {foreach from=$posts item=item key=key name=name}
                        <div class="mx-auto">
                            <a href="?page=post&id={$item["_id"]}" title="{$item.tags} score:{$item.score} rating:{$item.rating}">
                                <img src="{if $item.deleted}assets/img/deleted.png{elseif $item.status == "awaiting"}assets/img/pending.png{else}{$config.db.thumbs.0}/{$item.file.database.thumb}{/if}"
                                    alt="{$item.tags} score:{$item.score} rating:{$item.rating}"
                                    class="img2check mx-auto max-h-[200px] {if $item.deleted || $item.file.orientation == "landscape"}w-full h-auto{else}h-full w-auto{/if} {if $item.file.type.name == "video" && !$item.deleted && $item.status == "active"}border border-blue-500 border-4{elseif $item.deleted}border border-red-500 border-4{elseif $item.status == "awaiting"}border border-orange-500 border-4{/if}">

                            </a>
                        </div>
                    {/foreach}
                {/if}
                <div class="col-span-full mx-auto">
                    {if $pagination > 1}
                        <a href="?page={$page}&{if isset($searchquery)}query={$searchquery}&{/if}pagination=1"
                            class="text-sm bg-red-500 px-2 text-white hover:bg-red-300 border border-black">
                            &lt;&lt;
                        </a>
                        <a href="?page={$page}&{if isset($searchquery)}query={$searchquery}&{/if}pagination={$pagination - 1}"
                            class="text-sm bg-red-500 px-2 text-white hover:bg-red-300 border border-black">
                            &lt;
                        </a>
                    {/if}
                    {foreach from=$pagis item=item key=key name=name}
                        {if $pagination != $item}
                            <a href="?page={$page}&{if isset($searchquery)}query={$searchquery}&{/if}pagination={$item}"
                                class="text-sm bg-red-500 px-2 text-white hover:bg-red-300 border border-black">
                                {$item}
                            </a>
                        {else}
                            <span class="font-bold text-sm px-1">
                                {$item}
                            </span>
                        {/if}
                    {/foreach}
                    {if $pagination < $totalpages}
                        <a href="?page={$page}&{if isset($searchquery)}query={$searchquery}&{/if}pagination={$pagination + 1}"
                            class="text-sm bg-red-500 px-2 text-white hover:bg-red-300 border border-black">
                            &gt;
                        </a>
                        <a href="?page={$page}&{if isset($searchquery)}query={$searchquery}&{/if}pagination={$totalpages}"
                            class="text-sm bg-red-500 px-2 text-white hover:bg-red-300 border border-black">
                            &gt;&gt;
                        </a>
                    {/if}
                </div>
            </div>
        {else}
            {if !$post.deleted}
                <img src="{$config.db.uploads.0}/{$post.file.database.file}" class="w-auto max-w-full">
            {else}
                <div class="border border-2 border-red-500 p-2">
                    <p>
                        <span class="text-red-500 font-bold">This post has been deleted.</span>
                        Reason:
                        {if !empty($post.deletedReason)}
                            {$post.deletedReason}
                        {else}
                            Unknown.
                        {/if}
                    </p>
                </div>
            {/if}

            <h1 class="text-xl mt-2">
                {if $userlevel.perms.can_edit_post && !$post.deleted}
                    <span class="cursor-pointer text-red-500 hover:text-red-300"
                        onclick="toggleDiv('editDiv');">{$lang.edit}</span>
                    {if $userlevel.perms.can_comment}|{/if}
                {/if}
                {if $userlevel.perms.can_comment}
                    <span class="cursor-pointer text-red-500 hover:text-red-300"
                        onclick="toggleDiv('commentDiv');">{$lang.respond}</span>
                {/if}
            </h1>

            {if $userlevel.perms.can_edit_post && !$post.deleted}
                <div id="editDiv" class="mt-2 hidden">
                    <form method="POST" name="edit" class="w-full md:w-[600px]">

                        <label for="source">{$lang.source}:</label>
                        <input type="text" id="source" name="source" class="p-0 px-1 mb-1 w-full" value="{$post.source}"><br>

                        <label for="title">{$lang.title}:</label>
                        <input type="text" id="title" name="title" class="p-0 px-1 mb-1 w-full" value="{$post.title}"><br>

                        <label for="search">{$lang.tags}</label>
                        <p class="text-sm text-gray-700">{$lang.phrases.upload.tags}</p>
                        <textarea required name="tags" id="editSearch" class="w-full min-h-[100px] px-1"
                            onkeyup="doSearch('editSearch', 'editDisplay');">{$post.tags}</textarea><br>
                        <div id="editDisplay" class="w-full px-1"></div>

                        <div class="mb-2">
                            <p>{$lang.rating}:</p>
                            <div>
                                <div class="flex">
                                    <div class="flex items-center h-5">
                                        <input id="ratingSafe" type="radio" name="rating" value="safe"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300" required
                                            {if $post.rating == "safe"}checked{/if}>
                                    </div>
                                    <div class="ml-2 text-sm">
                                        <label for="ratingSafe" class="font-medium text-gray-900">Safe (SFW)</label>
                                        <p class="text-xs font-normal text-gray-500">
                                            You can look at it with your family (if you have one).
                                        </p>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex items-center h-5">
                                        <input id="questionable" type="radio" name="rating" value="questionable"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300" required
                                            {if $post.rating == "questionable"}checked{/if}>
                                    </div>
                                    <div class="ml-2 text-sm">
                                        <label for="questionable" class="font-medium text-gray-900">Questionable (Ecchi)</label>
                                        <p class="text-xs font-normal text-gray-500">
                                            No nudity, nipples to some extend okay, etc.
                                        </p>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex items-center h-5">
                                        <input id="explicit" type="radio" name="rating" value="explicit"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300" required
                                            {if $post.rating == "exlpicit"}checked{/if}>
                                    </div>
                                    <div class="ml-2 text-sm">
                                        <label for="explicit" class="font-medium text-gray-900">Explicit (NSFW)</label>
                                        <p class="text-xs font-normal text-gray-500">
                                            You don't want to share it anywhere in real life.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {if $config.captcha.enabled}
                            {if $config.captcha.type == "hcaptcha"}
                                <div class="h-captcha mt-2 w-full" data-sitekey="{$config.captcha.hcaptcha.sitekey}"></div>
                            {/if}
                        {/if}

                        <button type="submit" name="edit" class="bg-red-500 hover:bg-red-300 text-white p-0 px-2 mt-2 text-sm">
                            {$lang.edit}
                        </button>

                        {if isset($error)}
                            <p class="mt-2"><span class="text-red-500">{$lang.error}:</span> {$error}</p>
                        {/if}
                    </form>
                </div>
            {/if}
        {/if}
    </div>
</div>

{include file="part.footer.tpl"}