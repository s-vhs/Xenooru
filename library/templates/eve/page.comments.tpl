{include file="part.menu.tpl"}

<div class="mx-4 mt-2">
    <p id="image-replacement-message-div" class="cursor-pointer text-red-500 hover:text-red-300 hidden mt-2 text-sm">
        <b>
            <span id="image-replacement-message"></span>
        </b>
    </p>

    {foreach from=$comments item=item key=key name=name}
        <div class="grid grid-cols-8 gap-2 my-1 max-w-[70%] leading-none">
            <div class="col-span-1">
                <a href="browse.php?page=post&id={$item.post["_id"]}"
                    title="{$item.post.tags} score:{$item.post.score} rating:{$item.post.rating}">
                    <img src="{if $item.post.deleted}assets/img/deleted.png{elseif $item.post.status == "awaiting"}assets/img/pending.png{else}{$config.db.thumbs.0}/{$item.post.file.database.thumb}{/if}"
                        alt="If you're reading this, you have JavaScript disabled or try reloading the page"
                        class="img2check mx-auto max-h-[200px] {if $item.post.deleted || $item.post.status == "awaiting" || $item.post.file.orientation == "landscape"}w-[300px] h-auto{else}h-[200px] w-auto{/if} {if $item.post.file.type.name == "video" && !$item.post.deleted && $item.post.status == "active"}border border-blue-500 border-4{elseif $item.post.deleted}border border-red-500 border-4{elseif $item.post.status == "awaiting"}border border-orange-500 border-4{/if}">
                </a>
            </div>
            <div class="col-span-7">
                <span class="text-sm">
                    <b>Date</b> {$item.timestamp} <b>User</b> <a href="profile.php?id={$item.user._id}"
                        class="text-red-500 hover:text-red-300">{$item.user.username}</a> <b>Rating</b> {$item.post.rating}
                    <b>Score</b> {$item.post.score} <b><a href="browse.php?page=post&id={$item.post["_id"]}"
                            class="text-red-500 hover:text-red-300">View Post</a></b><br>
                    <b>Tags:</b>

                    <!-- Copyrights Block start -->
                    {if !empty($item.postTags.copyrights)}
                        {foreach from=$item.postTags.copyrights item=item key=key name=name}
                            <a href="browse.php?page=search&query={$item.full}"
                                class="text-fuchsia-500 hover:text-red-300">{$item.name}</a>
                        {/foreach}
                    {/if}
                    <!-- Copyrights block end -->
                    <!-- Characters Block start -->
                    {if !empty($item.postTags.characters)}
                        {foreach from=$item.postTags.characters item=item key=key name=name}
                            <a href="browse.php?page=search&query={$item.full}"
                                class="text-lime-500 hover:text-red-300">{$item.name}</a>
                        {/foreach}
                    {/if}
                    <!-- Characters block end -->
                    <!-- Artists Block start -->
                    {if !empty($item.postTags.artists)}
                        {foreach from=$item.postTags.artists item=item key=key name=name}
                            <a href="browse.php?page=search&query={$item.full}"
                                class="text-indigo-500 hover:text-red-300">{$item.name}</a>
                        {/foreach}
                    {/if}
                    <!-- Artists block end -->
                    <!-- Tags Block start -->
                    {if !empty($item.postTags.tags)}
                        {foreach from=$item.postTags.tags item=item key=key name=name}
                            <a href="browse.php?page=search&query={$item.full}"
                                class="text-red-500 hover:text-red-300">{$item.name}</a>
                        {/foreach}
                    {/if}
                    <!-- Tags block end -->
                    <!-- Metas Block start -->
                    {if !empty($item.postTags.metas)}
                        {foreach from=$item.postTags.metas item=item key=key name=name}
                            <a href="browse.php?page=search&query={$item.full}"
                                class="text-orange-500 hover:text-red-300">{$item.name}</a>
                        {/foreach}
                    {/if}
                    <!-- Metas block end -->

                </span>
                <div class="grid grid-cols-6 gap-1">
                    <div class="col-span-1">
                        <span class="text-xl">
                            <a class="text-red-500 font-bold hover:text-red-300"
                                href="profile.php?id={$item.user._id}">{$item.user.username}</a>
                        </span>
                        <br>
                        <span class="text-sm">
                            ({$item.timestamp})<br>
                            <span class="text-gray-400">>>#{$item._id}</span>
                        </span>
                    </div>
                    <div class="col-span-5">
                        <div>
                            {$item.comment}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {/foreach}
</div>

<div class="col-span-full text-center mx-auto">
    {if $pagination > 1}
        <a href="comments.php?pagination=1" class="text-sm bg-red-500 px-2 text-white hover:bg-red-300 border border-black">
            &lt;&lt;
        </a>
        <a href="comments.php?pagination={$pagination - 1}"
            class="text-sm bg-red-500 px-2 text-white hover:bg-red-300 border border-black">
            &lt;
        </a>
    {/if}
    {foreach from=$pagis item=item key=key name=name}
        {if $pagination != $item}
            <a href="comments.php?pagination={$item}"
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
        <a href="comments.php?pagination={$pagination + 1}"
            class="text-sm bg-red-500 px-2 text-white hover:bg-red-300 border border-black">
            &gt;
        </a>
        <a href="comments.php?pagination={$totalpages}"
            class="text-sm bg-red-500 px-2 text-white hover:bg-red-300 border border-black">
            &gt;&gt;
        </a>
    {/if}
</div>

{include file="part.footer.tpl"}