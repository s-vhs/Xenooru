{include file="part.menu.tpl"}

<div class="mx-4 mt-2">
    <p class="text-2xl font-bold">{$profile.username}</p>
    <div class="mt-2 relative overflow-x-auto">
        <table class="w-full text-sm text-left border border-black">
            <tbody>
                <tr class="hover:bg-red-200">
                    <th class="w-[15%]">
                        {$lang.contact}
                    </th>
                    <td>
                        <a href="mail.php?tab=compose&with={$profile._id}" class="text-red-500 hover:text-red-300">
                            {$lang.send_mail}
                        </a>
                    </td>
                </tr>
                <tr class="hover:bg-red-200">
                    <th class="w-[15%]">
                        {$lang.join_date}
                    </th>
                    <td>
                        {$profile.timestamp}
                    </td>
                </tr>
                <tr class="hover:bg-red-200">
                    <th class="w-[15%]">
                        {$lang.level}
                    </th>
                    <td>
                        {$profilelevel.name}
                    </td>
                </tr>
                <tr class="hover:bg-red-200">
                    <th class="w-[15%]">
                        {$lang.favourite_tags}
                    </th>
                    <td>
                        <s>{$lang.none}</s>
                    </td>
                </tr>
                <tr class="hover:bg-red-200">
                    <th class="w-[15%]">
                        {$lang.posts}
                    </th>
                    <td>
                        <a href="#" class="text-red-500 hover:text-red-300">
                            {$postcount}
                        </a>
                    </td>
                </tr>
                <tr class="hover:bg-red-200">
                    <th class="w-[15%]">
                        {$lang.deleted_posts}
                    </th>
                    <td>
                        <s>{$lang.none}</s>
                    </td>
                </tr>
                <tr class="hover:bg-red-200">
                    <th class="w-[15%]">
                        {$lang.favourites}
                    </th>
                    <td>
                        <a href="browse.php?page=favourites&user={$profile._id}"
                            class="text-red-500 hover:text-red-300">
                            {$favouritecount}
                        </a>
                    </td>
                </tr>
                <tr class="hover:bg-red-200">
                    <th class="w-[15%]">
                        {$lang.comments}
                    </th>
                    <td>
                        {$commentcount}
                    </td>
                </tr>
                <tr class="hover:bg-red-200">
                    <th class="w-[15%]">
                        {$lang.tag_edits}
                    </th>
                    <td>
                        <s>0</s>
                    </td>
                </tr>
                <tr class="hover:bg-red-200">
                    <th class="w-[15%]">
                        <s>{$lang.note_edits}</s>
                    </th>
                    <td>
                        <s>0</s>
                    </td>
                </tr>
                <tr class="hover:bg-red-200">
                    <th class="w-[15%]">
                        <s>{$lang.forum_posts}</s>
                    </th>
                    <td>
                        <s>0</s>
                    </td>
                </tr>
                <tr class="hover:bg-red-200">
                    <th class="w-[15%]">
                        {$lang.record}
                    </th>
                    <td>
                        <s>0</s>
                        (<a href="record.php?user={$profile._id}"
                            class="text-red-500 hover:text-red-300">{$lang.add}</a>)
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-4 "></div>

    <p id="image-replacement-message-div" class="cursor-pointer text-red-500 hover:text-red-300 hidden text-sm">
        <b>
            <span id="image-replacement-message"></span>
        </b>
    </p>

    <p class="text-xl font-bold mt-2">{$lang.recent_favourites} <a href="browse.php?page=favourites&user={$profile._id}"
            class="text-red-500 hover:text-red-300">»</a>
    </p>
    <div class="mt-2">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4">
            {foreach from=$profilefavourites item=item key=key name=name}
                <div class="mx-auto">
                    <a href="browse.php?page=post&id={$item["_id"]}"
                        title="{$item.tags} score:{$item.score} rating:{$item.rating}">
                        <img src="{if $item.deleted}assets/img/deleted.png{elseif $item.status == "awaiting"}assets/img/pending.png{else}{$config.db.thumbs.0}/{$item.file.database.thumb}{/if}"
                            alt="If you're reading this, you have JavaScript disabled or try reloading the page"
                            class="img2check mx-auto max-h-[200px] {if $item.deleted || $item.status == "awaiting" || $item.file.orientation == "landscape"}w-[300px] h-auto{else}h-[200px] w-auto{/if} {if $item.file.type.name == "video" && !$item.deleted && $item.status == "active"}border border-blue-500 border-4{elseif $item.deleted}border border-red-500 border-4{elseif $item.status == "awaiting"}border border-orange-500 border-4{/if}">

                    </a>
                </div>
            {/foreach}
        </div>
    </div>

    <p class="text-xl font-bold mt-4">{$lang.recent_uploads} <a href="#" class="text-red-500 hover:text-red-300">»</a>
    </p>
    <div class="mt-2">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4">
            {foreach from=$profileposts item=item key=key name=name}
                <div class="mx-auto">
                    <a href="browse.php?page=post&id={$item["_id"]}"
                        title="{$item.tags} score:{$item.score} rating:{$item.rating}">
                        <img src="{if $item.deleted}assets/img/deleted.png{elseif $item.status == "awaiting"}assets/img/pending.png{else}{$config.db.thumbs.0}/{$item.file.database.thumb}{/if}"
                            alt="If you're reading this, you have JavaScript disabled or try reloading the page"
                            class="img2check mx-auto max-h-[200px] {if $item.deleted || $item.status == "awaiting" || $item.file.orientation == "landscape"}w-[300px] h-auto{else}h-[200px] w-auto{/if} {if $item.file.type.name == "video" && !$item.deleted && $item.status == "active"}border border-blue-500 border-4{elseif $item.deleted}border border-red-500 border-4{elseif $item.status == "awaiting"}border border-orange-500 border-4{/if}">

                    </a>
                </div>
            {/foreach}
        </div>
    </div>
</div>

{include file="part.footer.tpl"}