{include file="part.menu.tpl"}

<div class="px-4 mt-2">
    {if $page == "post"}
        <h1 class="text-2xl">{$lang.tag_history}</h1>
        <h2 class="text-xl">{$lang.for_post} <a href="browse.php?page=post&id={$post._id}"
                class="text-red-500 hover:text-red-300">{$lang.id}: {$post._id}</a></h2>

        <div class="mt-2 relative overflow-x-auto">
            <table class="w-full text-sm text-left border border-black">
                <thead class="text-xs uppercase bg-red-500 text-white border border-black text-center">
                    <tr>
                        <th scope="col" class="px-2 py-1 border border-black">
                            {$lang.date}
                        </th>
                        <th scope="col" class="px-2 py-1 border border-black">
                            {$lang.user}
                        </th>
                        <th scope="col" class="px-2 py-1 border border-black">
                            {$lang.rating}
                        </th>
                        <th scope="col" class="px-2 py-1 border border-black">
                            {$lang.tags}
                        </th>
                        <th scope="col" class="px-2 py-1 border border-black">
                            {$lang.options}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$history item=item key=key name=name}
                        <tr class="bg-white hover:bg-gray-50 border border-black">
                            <td class="px-2 py-1">
                                {$item.timestamp}
                            </td>
                            <th class="px-2 py-1">
                                <a href="profile.php?id={$item.user}"
                                    class="text-red-500 hover:text-red-300">{$item.username}</a>
                            </th>
                            <td class="px-2 py-1">
                                {$item.rating}
                            </td>
                            <td class="px-2 py-1">
                                {$item.after}
                            </td>
                            <td class="px-2 py-1 text-right">
                                {$lang.none}
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    {/if}
</div>

{include file="part.footer.tpl"}