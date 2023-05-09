<div class="flex flex-row bg-red-500 text-white p-1 px-4 mt-2 space-x-3 text-sm font-medium">
    <p>
        <button data-modal-target="default" data-modal-toggle="cutomizationModal" class="underline hover:text-red-300"
            type="button">
            {$lang.customize}
        </button>
    </p>
    <p>
        {$lang.media_copyright_by_their_respective_owners}
    </p>
    <p>
        {$lang.proudly_powered_by} <a href="https://github.com/s-vhs/Xenooru" target="_blank"
            class="underline hover:text-red-300">Xenooru</a>
    </p>
    <p>
        {$lang.developed_by} <a href="https://github.com/s-vhs" target="_blank"
            class="underline hover:text-red-300">Elysium</a>,
        <a href="https://github.com/saintly2k" target="_blank" class="underline hover:text-red-300">Saintly2k</a> &
        <a href="https://github.com/s-vhs/Xenooru/graphs/contributors" target="_blank"
            class="underline hover:text-red-300">{$lang.the_team}</a>
    </p>
    <p>
        {$lang.content_loaded_in} {$loadingtime} {$lang.seconds}
    </p>
    {if !empty($config.email.general)}
        <p>
            <a href="mailto:{$config["email"]["general"]}" target="_blank"
                class="underline hover:text-red-300">{$lang.contact}</a>
        </p>
    {/if}
</div>

<div id="cutomizationModal" tabindex="-1"
    class="fixed top-0 left-0 right-0 z-50 hidden w-screen md:w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
    <div class="relative w-full h-full max-w-md md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-2 border-b bg-red-500 text-white">
                <h3 class="text-xl font-medium">
                    {$lang.customize}
                </h3>
                <button type="button"
                    class="bg-transparent hover:bg-red-300 text-sm p-1.5 ml-auto inline-flex items-center"
                    data-modal-toggle="cutomizationModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form method="POST" name="customize">
                <div class="p-2">
                    <label for="theme">{$lang.theme}:</label>
                    <select name="theme" class="p-0 w-full mt-0 px-1" id="theme">
                        {foreach from=$themes item=item key=key name=name}
                            <option value="{$item.directory}" {if $usertheme == $item.directory}selected{/if}>{$item.name}
                                (by
                                {$item.author})</option>
                        {/foreach}
                    </select>
                    <label for="lang">{$lang.language}:</label>
                    <select name="lang" class="p-0 w-full mt-0 px-1" id="lang">
                        {foreach from=$langs item=item key=key name=name}
                            <option value="{$item.short}" {if $userlang == $item.short}selected{/if}>{$item.name} (by
                                {$item.author})</option>
                        {/foreach}
                    </select>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-2 space-x-2 border-t border-gray-200">
                    <button data-modal-toggle="cutomizationModal" type="submit" name="customize"
                        class="text-white bg-red-500 hover:bg-red-300 font-medium px-2 text-center">{$lang.save}</button>
                    <button data-modal-toggle="cutomizationModal" type="button"
                        class="text-gray-500 bg-white hover:bg-gray-100 border border-gray-200 font-medium px-2 hover:text-gray-900">{$lang.close}</button>
                </div>
            </form>
        </div>
    </div>
</div>