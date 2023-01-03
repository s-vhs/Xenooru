{include file="part.menu.tpl"}

<div class="mx-4 mt-2 mx-auto animate__animated animate__fadeIn">
    {if $tab == "home"}
        <h1 class="text-xl font-bold">
            <a href="mailto:{$config.email.general}" class="text-red-500 hover:text-red-300" target="_blank">
                » {$lang.contact_us}
            </a>
        </h1>
        <h1 class="text-xl font-bold mt-1">
            <a href="?tab=about" class="text-red-500 hover:text-red-300">
                » {$lang.about}
            </a>
        </h1>
        <h1 class="text-xl font-bold mt-1">
            <a href="?tab=help" class="text-red-500 hover:text-red-300">
                » {$lang.help}
            </a>
        </h1>
        <h1 class="text-xl font-bold mt-1">
            <a href="?tab=tos" class="text-red-500 hover:text-red-300">
                » {$lang.terms_of_service}
            </a>
        </h1>
        <h1 class="text-xl font-bold mt-1">
            <a href="?tab=privacy" class="text-red-500 hover:text-red-300">
                » {$lang.privacy_policy}
            </a>
        </h1>
    {elseif $tab == "about"}
        <h1 class="text-xl font-bold">
            {$lang.about}
        </h1>
        <p>This site is an instance of <a href="https://github.com/s-vhs/Xenooru" target="_blank"
                class="text-red-500 hover:text-red-300">Xenooru</a>.</p>
        <p>
            <a href="https://github.com/s-vhs/Xenooru" target="_blank" class="text-red-500 hover:text-red-300">Xenooru</a>
            is a Booru, inspired by Danbooru. However, it uses its own code and does not rely on old one.
        </p>
        <p>
            In addition, it is open-source and everyone can contribute.
        </p>
    {/if}
</div>

{include file="part.footer.tpl"}