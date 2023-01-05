{include file="part.menu.tpl"}

<div class="mt-2 p-4 md:p-0 md:mx-4 animate__animated animate__fadeIn w-screen md:w-[400px]">
    <h1 class="text-2xl font-bold">{$lang.upload}</h1>

    <form method="post" name="upload" enctype="multipart/form-data">
        <input required class="w-full mt-2 text-sm text-gray-900 border border-gray-300 cursor-pointer bg-gray-50"
            id="file" type="file" name="file">
        <p class="text-sm text-gray-500">
            {$lang.only}
            {foreach from=$config.upload.allowed.img item=item key=key name=name}
                {$item}
            {/foreach}
            {foreach from=$config.upload.allowed.video item=item key=key name=name}
                {$item}
            {/foreach}
        </p>
        <p class="text-sm text-gray-500 mb-2">
            {$lang.max} {formatBytes($config.upload.max)}
        </p>

        <label for="source">{$lang.source}:</label>
        <input type="text" id="source" name="source" class="p-0 px-1 mb-1 w-full"><br>

        <label for="title">{$lang.title}:</label>
        <input type="text" id="title" name="title" class="p-0 px-1 mb-1 w-full"><br>

        <label for="search">{$lang.tags}</label>
        <p class="text-sm text-gray-700">{$lang.phrases.upload.tags}</p>
        <textarea required name="tags" id="search" class="w-full min-h-[100px] px-1"></textarea><br>
        <div id="display" class="w-full px-1"></div>

        <div class="mb-2">
            <p>{$lang.rating}:</p>
            <div>
                <div class="flex">
                    <div class="flex items-center h-5">
                        <input id="ratingSafe" type="radio" name="rating" value="safe"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300" required>
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
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300" required>
                    </div>
                    <div class="ml-2 text-sm">
                        <label for="questionable" class="font-medium text-gray-900">Questionable (Ecchi)</label>
                        <p class="text-xs font-normal text-gray-500">
                            No nudity, niples, sexual poses, etc.
                        </p>
                    </div>
                </div>
                <div class="flex">
                    <div class="flex items-center h-5">
                        <input id="explicit" type="radio" name="rating" value="explicit"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300" required>
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

        <p><a href="more.php?tab=tos" target="_blank"
                class="text-red-500 hover:text-red-300">{$lang.terms_of_service}</a>:</p>
        <label>
            <input type="checkbox" required name="acceptToS">
            {$lang.phrases.upload.tos}
        </label>

        <p class="mt-2"><a href="more.php?tab=privacy" target="_blank"
                class="text-red-500 hover:text-red-300">{$lang.privacy_policy}</a>:</p>
        <label>
            <input type="checkbox" required name="acceptPrivacy">
            {$lang.phrases.upload.privacy}
        </label>

        {if $config.captcha.enabled}
            {if $config.captcha.type == "hcaptcha"}
                <div class="h-captcha mt-2 w-full" data-sitekey="{$config.captcha.hcaptcha.sitekey}"></div>
            {/if}
        {/if}
        <button type="submit" name="upload" class="bg-red-500 hover:bg-red-300 text-white p-0 px-2 mt-2 text-sm">
            {$lang.upload}
        </button>

        {if isset($error)}
            <p class="mt-2"><span class="text-red-500">{$lang.error}:</span> {$error}</p>
        {/if}
    </form>
</div>

{include file="part.footer.tpl"}