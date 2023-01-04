{include file="part.menu.tpl"}

<div class="grid grid-cols-10 gap-2 mx-4 mt-2">
    <div class="grid-span-2">
        <form method="GET" name="search" action="browse.php">
            <input type="text" name="page" value="search" hidden readonly>
            <label for="search" class="text-sm">{$lang.search}:</label>
            <input type="text" name="query" class="mx-auto px-1 text-sm p-0 w-full" id="search"
                value="{if isset($searchquery)}{$searchquery}{/if}">
            <button type="submit"
                class="text-sm text-center bg-red-500 hover:bg-red-300 w-full text-white">{$lang.search}</button>
        </form>
    </div>
    {if $page != "post"}
        <div class="col-span-8 grid grid-cols-6 gap-4">
            {if $page == "browse"}
                {foreach from=$posts item=item key=key name=name}
                    <div class="mx-auto">
                        <a href="?page=post&id={$item["_id"]}" title="{$item.tags} score:{$item.score} rating:{$item.rating}">
                            <img src="{$config.db.thumbs.0}/{$item.file.database.thumb}"
                                alt="{$item.tags} score:{$item.score} rating:{$item.rating}"
                                class="max-h-[200px] {if $item.file.orientation == "landscape"}w-full h-auto{else}h-full w-auto{/if}">
                        </a>
                    </div>
                {/foreach}
            {elseif $page == "search"}
                {foreach from=$posts item=item key=key name=name}
                    <div class="mx-auto">
                        <a href="?page=post&id={$item["_id"]}" title="{$item.tags} score:{$item.score} rating:{$item.rating}">
                            <img src="{$config.db.thumbs.0}/{$item.file.database.thumb}"
                                alt="{$item.tags} score:{$item.score} rating:{$item.rating}"
                                class="max-h-[200px] {if $item.file.orientation == "landscape"}w-full h-auto{else}h-full w-auto{/if}">
                        </a>
                    </div>
                {/foreach}
            {/if}
        </div>
        <div class="col-span-10 mt-2 space-x-1 text-center">
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
                <a href="?page={$page}&{if isset($searchquery)}query={$searchquery}&{/if}pagination={$totalpages}" class="text-sm bg-red-500 px-2 text-white hover:bg-red-300 border border-black">
                    &gt;&gt;
                </a>
            {/if}
        </div>
    {else}
    {/if}
</div>

{include file="part.footer.tpl"}