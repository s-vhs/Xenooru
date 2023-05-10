{include file="part.menu.tpl"}

<div class="mx-4 mt-2 animate__animated animate__fadeIn">
    {if $tab == "home"}
        <h1 class="text-2xl">{$lang.wiki} - {$lang.page} 0</h1>
    {elseif $tab == "term"}
        <h1 class="text-2xl">{$lang.term}: <a href="browse.php?page=search&query={$smarty.get.term|escape}"
                class="text-red-500 hover:text-red-300">{$smarty.get.term|escape}</a></h1>
        {if $exists}
            <p>
                {bbcodeLink($term.description)}
            </p>
        {else}
            <p>
                {$lang.this_term_has_no_definition_yet}.
            </p>

            {if $userlevel.perms.can_edit_wiki}
                <p>
                    Edit this tag
                </p>
            {else}
                <p>
                    You don't have permission to edit this entry.
                </p>
            {/if}
        {/if}
    {/if}
</div>

{include file="part.footer.tpl"}