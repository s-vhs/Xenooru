<div>
    <a href="browse.php">
        <img src="{$config.logo}" alt="{$lang.logo}" class="w-full animate__animated animate__fadeInDown">
    </a>
    <p class="text-center animate__animated animate__fadeInUp">
        <a href="browse.php" class="mx-2 text-red-500 hover:text-red-300">{$lang.browse}</a>
        <a href="comments.php" class="mx-2 text-red-500 hover:text-red-300">{$lang.comments}</a>
        <a href="account.php" class="mx-2 text-red-500 hover:text-red-300">{$lang.my_account}</a>
        <a href="forums.php" class="mx-2 text-red-500 hover:text-red-300">{$lang.forums}</a>
    </p>
    <form method="GET" name="search" action="browse.php">
        <input type="text" name="page" value="search" hidden readonly>
        <div class="flex items-center">
            <input type="text" name="query" class="mx-auto mt-1 p-0 w-[350px] animate__animated animate__fadeInUp">
        </div>
        <div class="flex items-center">
            <input type="submit"
                class="mx-auto border border-black bg-gray-300 mt-1 px-2 hover:bg-gray-400 cursor-pointer animate__animated animate__fadeInUp"
                value="{$lang.search}">
        </div>
    </form>
    <p class="mt-1 text-center text-gray-500 text-sm animate__animated animate__fadeInUp">
        <a href="https://github.com/s-vhs/Xenooru" target="_blank" class="underline">{$lang.running_xenooru}
            {$version}</a> |
        {$lang.total_unique_visits}: {$totalvisits}
    </p>
    <div class="mt-1">
        {foreach from=$totalposts item=item key=id}
            <img src="assets/counter/{$item}.gif" class="mx-auto animate__animated animate__zoomIn">
        {/foreach}
    </div>
</div>