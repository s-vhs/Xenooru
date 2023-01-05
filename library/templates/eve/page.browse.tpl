{include file="part.menu.tpl"}

<div class="grid grid-cols-10 gap-2 mx-4 mt-2">
    <div class="grid-span-2">
        <form method="GET" name="search" action="browse.php">
            <input type="text" name="page" value="search" hidden readonly>
            <label for="search" class="text-sm">{$lang.search}:</label>
            <input type="text" name="query" class="mx-auto px-1 text-sm p-0 w-full" id="search"
                value="{if isset($searchquery)}{$searchquery}{/if}">
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
                            <a href="wiki.php?term={$item.name}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.name}"
                                class="hover:underline">+</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.name}"
                                class="hover:underline">-</a>
                            <a href="?page=search&query={$item.name}" class="text-fuchsia-500 hover:text-red-300">{$item.name}</a>
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
                            <a href="wiki.php?term={$item.name}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.name}"
                                class="hover:underline">+</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.name}"
                                class="hover:underline">-</a>
                            <a href="?page=search&query={$item.name}"
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
                            <a href="wiki.php?term={$item.name}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.name}"
                                class="hover:underline">+</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.name}"
                                class="hover:underline">-</a>
                            <a href="?page=search&query={$item.name}"
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
                            <a href="wiki.php?term={$item.name}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.name}"
                                class="hover:underline">+</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.name}"
                                class="hover:underline">-</a>
                            <a href="?page=search&query={$item.name}"
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
                            <a href="wiki.php?term={$item.name}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.name}"
                                class="hover:underline">+</a>
                            <a href="?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.name}"
                                class="hover:underline">-</a>
                            <a href="?page=search&query={$item.name}"
                                class="text-orange-500 hover:text-red-300">{str_replace("_", " ", $item.name)}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Metas block end -->
            </ul>
        {/if}
        <!-- Chibi start -->
        <img src="assets/{$theme.directory}/{$config.chibi}" class="mt-2 w-full" alt="Chibi!">
        <!-- Chibi end -->
    </div>
    {if $page != "post"}
        <div class="col-span-8">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4">
                {if $page == "browse" || $page == "search"}
                    {foreach from=$posts item=item key=key name=name}
                        <div class="mx-auto">
                            <a href="?page=post&id={$item["_id"]}" title="{$item.tags} score:{$item.score} rating:{$item.rating}">
                                <img src="{$config.db.thumbs.0}/{$item.file.database.thumb}"
                                    alt="{$item.tags} score:{$item.score} rating:{$item.rating}"
                                    class="max-h-[200px] {if $item.file.orientation == "landscape"}w-full h-auto{else}h-full w-auto{/if} {if $item.file.type.name == "video" && !$item.deleted && $item.status == "active"}border border-blue-500 border-4{elseif $item.deleted}border border-red-500 border-4{elseif $item.status == "awaiting"}border border-orange-500 border-4{/if}">
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
        </div>
    {else}
    {/if}
</div>

{include file="part.footer.tpl"}