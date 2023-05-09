{include file="part.menu.tpl"}

<div class="mx-4 mt-2 animate__animated animate__fadeIn">
    {if $tab == "home"}
        {if !empty($config.email.general)}
            <h1 class="text-xl font-bold">
                <a href="mailto:{$config.email.general}" class="text-red-500 hover:text-red-300" target="_blank">
                    » {$lang.contact_us}
                </a>
            </h1>
        {/if}
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
        <h1 class="text-2xl font-bold">
            {$lang.about}
        </h1>
        <p>This site is an instance of <a href="https://github.com/s-vhs/Xenooru" target="_blank"
                class="text-red-500 hover:text-red-300">Xenooru</a>.</p>
        <p>
            <a href="https://github.com/s-vhs/Xenooru" target="_blank" class="text-red-500 hover:text-red-300">Xenooru</a>
            is a Booru, inspired by Danbooru and shimmie2. However, it uses its own code and does not rely on old one.
        </p>
        <p>
            In addition, it is open-source and everyone can contribute.
        </p>
    {elseif $tab == "help"}
        <div class="w-full md:w-[550px]">
            <h1 class="text-2xl font-bold">
                {$lang.help}
            </h1>

            <h1 class="mt-3 text-xl font-bold text-green-700">
                {$lang.posts}
            </h1>
            <p class="text-sm">
                {$lang.phrases.help.posts}
            </p>

            <h1 class="mt-3 text-xl font-bold text-green-700">
                {$lang.search}
            </h1>
            <p class="text-sm">
                {$lang.phrases.help.search}
            </p>

            <h1 class="mt-3 text-xl font-bold text-green-700">
                {$lang.safe_images_only_mode}
            </h1>
            <p class="text-sm">
                {$lang.phrases.help.safe_images_only_mode}
            </p>
            <p class="text-sm mt-2">
                {$lang.phrases.help.safe_images_only_mode2}
            </p>

            <h1 class="mt-3 text-xl font-bold text-green-700">
                {$lang.tag_list}
            </h1>
            <p class="text-sm">
                {$lang.phrases.help.tag_list}
            </p>
            <p class="text-sm mt-2 font-bold">?</p>
            <p class="text-sm">
                {$lang.phrases.help.tag_list_question}
            </p>
            <p class="text-sm mt-2 font-bold">+</p>
            <p class="text-sm">
                {$lang.phrases.help.tag_list_plus}
            </p>
            <p class="text-sm mt-2 font-bold">-</p>
            <p class="text-sm">
                {$lang.phrases.help.tag_list_minus}
            </p>
            <p class="text-sm mt-2 font-bold">950</p>
            <p class="text-sm">
                {$lang.phrases.help.tag_list_number}
            </p>
            <p class="text-sm mt-2 font-bold">{$lang.color}</p>
            <p class="text-sm">
                {$lang.phrases.help.tag_list_color}
            </p>
            <p class="text-sm mt-2">
                {$lang.phrases.help.tag_list_color2}
            </p>

            <h1 class="mt-3 text-xl font-bold text-green-700">
                {$lang.types}
            </h1>
            <p class="text-sm">
                {$lang.phrases.help.types}
            </p>
            <p class="text-sm mt-2 font-bold">{$lang.artist}</p>
            <p class="text-sm">
                {$lang.phrases.help.artist}
            </p>
            <p class="text-sm mt-2">
                {$lang.phrases.help.artist2}
            </p>
            <p class="text-sm mt-2 font-bold">{$lang.character}</p>
            <p class="text-sm">
                {$lang.phrases.help.character}
            </p>
            <p class="text-sm mt-2 font-bold">{$lang.copyright}</p>
            <p class="text-sm">
                {$lang.phrases.help.copyright}
            </p>

            <h1 class="mt-3 text-xl font-bold text-green-700">
                {$lang.artifacts}
            </h1>
            <p class="text-sm">
                {$lang.phrases.help.artifacts}
            </p>
            <p class="text-sm mt-2 font-bold">{$lang.examples}</p>
            <p class="text-sm">
                {$lang.phrases.help.examples}
            </p>
            <ol class="text-sm list-decimal list-inside mt-2">
                <li><a href="assets/artifacts/1.jpg" target="_blank"
                        class="text-red-500 hover:text-red-300">{$lang.phrases.help.artifacts1}</a></li>
                <li><a href="assets/artifacts/2.jpg" target="_blank"
                        class="text-red-500 hover:text-red-300">{$lang.phrases.help.artifacts2}</a></li>
                <li><a href="assets/artifacts/3.jpg" target="_blank"
                        class="text-red-500 hover:text-red-300">{$lang.phrases.help.artifacts3}</a></li>
                <li><a href="assets/artifacts/4.jpg" target="_blank"
                        class="text-red-500 hover:text-red-300">{$lang.phrases.help.artifacts4}</a></li>
            </ol>
        </div>
    {elseif $tab == "tos"}
        <div class="w-full md:w-[750px]">
            <h1 class="text-2xl font-bold">
                {$lang.terms_of_service}
            </h1>
            <p class="text-sm">
                {$lang.phrases.tos.tos}
            </p>
            <ul class="text-sm list-disc list-inside mt-2">
                {foreach from=$lang.phrases.tos.tos_list item=item key=pos}
                    <li>{$item}</li>
                {/foreach}
            </ul>

            <h1 class="text-xl font-bold mt-3 text-green-700">
                {$lang.prohibited_content}
            </h1>
            <p class="text-sm">
                {$lang.phrases.tos.prohibited_content}
            </p>
            <ul class="text-sm list-disc list-inside mt-2">
                {foreach from=$lang.phrases.tos.pc_list item=item key=pos}
                    <li>{$item}</li>
                {/foreach}
            </ul>

            <h1 class="text-xl font-bold mt-3 text-green-700">
                {$lang.agreement}
            </h1>
            <p class="text-sm">
                {$lang.phrases.tos.agreement} <a href="https://duckduckgo.com/"
                    class="text-red-500 hover:text-red-300">{$lang.phrases.tos.leave_now}</a>
            </p>
        </div>
    {elseif $tab == "privacy"}
        <div class="w-full md:w-[750px]">
            <h1 class="text-2xl font-bold">
                {$lang.privacy_policy}
            </h1>
            <p class="text-sm">
                {$lang.phrases.privacy_policy.privacy_policy}
            </p>
            <p class="text-sm mt-2">
                {$lang.phrases.privacy_policy.privacy_policy2}
            </p>
            <p class="text-sm mt-2">
                {$lang.phrases.privacy_policy.privacy_policy3}
            </p>
            <p class="text-sm mt-2">
                {$lang.phrases.privacy_policy.privacy_policy4}
            </p>

            <h1 class="text-xl font-bold mt-3 text-green-700">
                {$lang.what_information_we_hold_about_you}
            </h1>
            <p class="text-sm">
                {$lang.phrases.privacy_policy.what_info}
            </p>
            <ul class="mt-2 list-disc list-inside text-sm">
                {foreach from=$lang.phrases.privacy_policy.list_what_info item=item key=key}
                    <li>{$item}</li>
                {/foreach}
            </ul>

            <p class="mt-2 font-bold text-sm">{$lang.log_files}</p>
            <p class="text-sm">
                {$lang.phrases.privacy_policy.log_files}
            </p>

            <p class="mt-2 font-bold text-sm">{$lang.cookies_and_web_beacons}</p>
            <p class="text-sm">
                {$lang.phrases.privacy_policy.cookies_and_web_beacons}
            </p>

            <h1 class="text-xl font-bold mt-3 text-green-700">
                {$lang.how_your_personal_information_is_used}
            </h1>
            <p class="text-sm">
                {$lang.phrases.privacy_policy.how_your_personal_information_is_used}
            </p>
            <ul class="mt-2 list-disc list-inside text-sm">
                {foreach from=$lang.phrases.privacy_policy.list_how_personal_information item=item key=key}
                    <li>{$item}</li>
                {/foreach}
            </ul>

            <p class="text-sm mt-2">
                {$lang.phrases.privacy_policy.how_your_personal_information_is_used2}
            </p>

            <h1 class="text-xl font-bold mt-3 text-green-700">
                {$lang.keeping_your_data_secure}
            </h1>
            <p class="text-sm">
                {$lang.phrases.privacy_policy.keeping_your_data_secure}
            </p>

            <h1 class="text-xl font-bold mt-3 text-green-700">
                {$lang.acceptance_of_this_policy}
            </h1>
            <p class="text-sm">
                {$lang.phrases.privacy_policy.acceptance_of_this_policy}
            </p>

            <h1 class="text-xl font-bold mt-3 text-green-700">
                {$lang.changes_to_this_policy}
            </h1>
            <p class="text-sm">
                {$lang.phrases.privacy_policy.changes_to_this_policy}
            </p>

            <p class="text-sm mt-2">
                {$lang.phrases.privacy_policy.privacy_policy5}
            </p>
        </div>
    {/if}
</div>

{include file="part.footer.tpl"}