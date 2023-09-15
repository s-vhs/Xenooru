{include file="part.menu.tpl"}

<div class="grid grid-cols-8 gap-2 mx-4 mt-2">
    <div class="col-span-1">
        <form method="GET" name="search" action="browse.php">
            <input type="text" name="page" value="search" hidden readonly>
            <label for="search" class="text-sm">{$lang.search}:</label>
            <input onkeyup="doSearch('search', 'display')" type="text" name="query"
                class="mx-auto px-1 text-sm p-0 w-full" id="search" value="{if isset($searchquery)}{$searchquery}{/if}">
            <div id="display" class="w-full"></div>
            <button type="submit"
                class="text-sm text-center bg-red-500 hover:bg-red-300 w-full text-white">{$lang.search}</button>
        </form>
        {if $page == "browse" || $page == "search" || $page == "favourites"}
            <p id="image-replacement-message-div"
                class="cursor-pointer text-red-500 hover:text-red-300 hidden mt-2 text-sm">
                <b>
                    <span id="image-replacement-message"></span>
                </b>
            </p>
            <p class="font-bold mt-2">{$lang.tags}</p>
            <ul class="text-sm">
                <!-- Copyrights Block start -->
                {if !empty($tags.copyrights)}
                    <li class="font-bold">{$lang.copyrights}</li>
                    {foreach from=$tags.copyrights item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="browse.php?page=search&query={$item.full}"
                                class="text-fuchsia-500 hover:text-red-300">{$item.name}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Copyrights block end -->
                <!-- Characters Block start -->
                {if !empty($tags.characters)}
                    <li class="font-bold">{$lang.characters}</li>
                    {foreach from=$tags.characters item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="browse.php?page=search&query={$item.full}"
                                class="text-lime-500 hover:text-red-300">{str_replace("_", " ", $item.name)}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Characters block end -->
                <!-- Artists Block start -->
                {if !empty($tags.artists)}
                    <li class="font-bold">{$lang.artists}</li>
                    {foreach from=$tags.artists item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="browse.php?page=search&query={$item.full}"
                                class="text-indigo-500 hover:text-red-300">{str_replace("_", " ", $item.name)}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Artists block end -->
                <!-- Tags Block start -->
                {if !empty($tags.tags)}
                    <li class="font-bold">{$lang.general}</li>
                    {foreach from=$tags.tags item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="browse.php?page=search&query={$item.full}"
                                class="text-red-500 hover:text-red-300">{str_replace("_", " ", $item.name)}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Tags block end -->
                <!-- Metas Block start -->
                {if !empty($tags.metas)}
                    <li class="font-bold">{$lang.metas}</li>
                    {foreach from=$tags.metas item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="browse.php?page=search&query={$item.full}"
                                class="text-orange-500 hover:text-red-300">{str_replace("_", " ", $item.name)}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Metas block end -->
            </ul>
        {elseif $page == "post"}
            <p class="font-bold mt-2">{$lang.tags}</p>
            <ul class="text-sm">
                <!-- Copyrights Block start -->
                {if !empty($tags.copyrights)}
                    <li class="font-bold">{$lang.copyrights}</li>
                    {foreach from=$tags.copyrights item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="browse.php?page=search&query={$item.full}"
                                class="text-fuchsia-500 hover:text-red-300">{$item.name}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Copyrights block end -->
                <!-- Characters Block start -->
                {if !empty($tags.characters)}
                    <li class="font-bold">{$lang.characters}</li>
                    {foreach from=$tags.characters item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="browse.php?page=search&query={$item.full}"
                                class="text-lime-500 hover:text-red-300">{str_replace("_", " ", $item.name)}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Characters block end -->
                <!-- Artists Block start -->
                {if !empty($tags.artists)}
                    <li class="font-bold">{$lang.artists}</li>
                    {foreach from=$tags.artists item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="browse.php?page=search&query={$item.full}"
                                class="text-indigo-500 hover:text-red-300">{str_replace("_", " ", $item.name)}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Artists block end -->
                <!-- Tags Block start -->
                {if !empty($tags.tags)}
                    <li class="font-bold">{$lang.general}</li>
                    {foreach from=$tags.tags item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="browse.php?page=search&query={$item.full}"
                                class="text-red-500 hover:text-red-300">{str_replace("_", " ", $item.name)}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Tags block end -->
                <!-- Metas Block start -->
                {if !empty($tags.metas)}
                    <li class="font-bold">{$lang.metas}</li>
                    {foreach from=$tags.metas item=item key=key name=name}
                        <li>
                            <a href="wiki.php?term={$item.full}" class="text-red-500 hover:text-red-300">?</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}{$item.full}"
                                class="hover:underline">+</a>
                            <a href="browse.php?page=search&query={if isset($searchquery)}{$searchquery}+{/if}-{$item.full}"
                                class="hover:underline">-</a>
                            <a href="browse.php?page=search&query={$item.full}"
                                class="text-orange-500 hover:text-red-300">{str_replace("_", " ", $item.name)}</a>
                            {$item.count}
                        </li>
                    {/foreach}
                {/if}
                <!-- Metas block end -->
            </ul>
            <!-- Statistics Block start -->
            <p class="font-bold mt-2">{$lang.statistics}</p>
            <ul class="text-sm">
                <li>{$lang.id}: {$post._id}</li>
                <li>{$lang.posted}: {$post.timestamp}</li>
                <li>{$lang.by} <a href="users.php?id={$poster._id}"
                        class="text-red-500 hover:text-red-300">{$poster.username}</a></li>
                {if isset($post.file.dimensions)}
                    <li>{$lang.dimensions}: {$post.file.dimensions}</li>
                {/if}
                {if isset($post.file.size)}
                    <li>{$lang.size}: {formatBytes($post.file.size)}</li>
                {/if}
                {if !empty($post.source)}
                    <lil>{$lang.source}: <a href="{$post.source}" target="_blank"
                            class="text-red-500 hover:text-red-300">{$lang.visit}</a></lil>
                {/if}
                <li>{$lang.rating}: {ucfirst($post.rating)}</li>
                <li>{$lang.score}:
                    <span id="scoreCount">{$post.score}</span>
                    {if $userlevel.perms.can_vote_post}({$lang.vote}
                        <span class="text-red-500 hover:text-red-300 cursor-pointer"
                            onclick="votePostUp({$post._id})">{$lang.up}</span>/<span
                            class="text-red-500 hover:text-red-300 cursor-pointer"
                            onclick="votePostDown({$post._id})">{$lang.down}</span>)
                    {/if}
                </li>
                <li id="voteDiv" class="italic text-red-500"></li>
            </ul>
            <!-- Statistics Block end -->
            <!-- Options Block start -->
            <p class="font-bold mt-2">{$lang.options}</p>
            <ul class="text-sm">
                {if $userlevel.perms.can_edit_post && !$post.deleted}
                    <li><span class="text-red-500 hover:text-red-300 cursor-pointer"
                            onclick="toggleDiv('editDiv');">{$lang.edit}</span></li>
                {/if}
                <li class="font-bold"><a href="{$config.db.uploads.0}/{$post.file.database.file}" target="_blank"
                        class="text-red-500 hover:text-red-300">{$lang.original_image}</a></li>
                {if $userlevel.perms.can_delete_post || ($logged && $user._id == $poster._id)}
                    {if !$post.deleted}
                        <li>
                            <a onclick="deletePost({$post._id});"
                                class="cursor-pointer text-red-500 hover:text-red-300">{$lang.delete}</a>
                        </li>
                    {elseif $post.deleted && $userlevel.perms.can_delete_post}
                        <li>
                            <a onclick="recoverPost({$post._id});"
                                class="cursor-pointer text-red-500 hover:text-red-300">{$lang.recover}</a>
                        </li>
                    {/if}
                {/if}
                {if isset($hasFlaggedForDeletion)}
                    {if $userlevel.perms.can_report && !$hasFlaggedForDeletion}
                        {if !$post.deleted}
                            <li id="deletionFlag">
                                <a class="cursor-pointer text-red-500 hover:text-red-300" onclick="flagForDeletion({$post._id});">
                                    {$lang.flag_for_deletion}
                                </a>
                            </li>
                        {/if}
                    {elseif $hasFlaggedForDeletion && isset($deletionFlagRejectionReason) && !empty($deletionFlagRejectionReason)}
                        <li class="text-italic">{$lang.your_report_has_been_rejected}. {$lang.reason}:
                            {$deletionFlagRejectionReason}</li>
                    {/if}
                {/if}
                {if $userlevel.perms.can_manage_favourites}
                    <li>
                        <a class="cursor-pointer text-red-500 hover:text-red-300" onclick="{if $favourited}removeFromFavs({$post._id});
                            {else}addToFavs({$post._id});{/if}"
                            id="favouriteText">{if $favourited}{$lang.remove_from_favourites}{else}{$lang.add_to_favourites}{/if}</a>
                    </li>
                {/if}
            </ul>
            <!-- Options Block end -->

            <!-- History Block start -->
            <p class="font-bold mt-2">{$lang.history}</p>
            <ul class="text-sm">
                <li>
                    <a href="logs.php?page=post&id={$post._id}" class="text-red-500 hover:text-red-300">{$lang.tags}</a>
                </li>
            </ul>
            <!-- History Block end -->

            <!-- Related Posts Block start -->
            <p class="font-bold mt-2">{$lang.related_posts}</p>
            <ul class="text-sm">
                <li>
                    <a href="https://saucenao.com/search.php?url={$url}{$config.db.uploads.0}/{$post.file.database.file}"
                        class="text-red-500 hover:text-red-300" target="_blank">{$lang.saucenao}</a>
                </li>
                <li>
                    <a href="https://iqdb.org/?url={$url}{$config.db.uploads.0}/{$post.file.database.file}"
                        class="text-red-500 hover:text-red-300" target="_blank">{$lang.iqdb}</a>
                </li>
                <li>
                    <a href="https://waifu2x.booru.pics/Home/fromlink?denoise=1&scale=2&url={$url}{$config.db.uploads.0}/{$post.file.database.file}"
                        class="text-red-500 hover:text-red-300" target="_blank">{$lang.waifu2x}</a>
                </li>
            </ul>
            <!-- Related Posts Block end -->
        {/if}
        <!-- Chibi start -->
        <img src="assets/{$theme.directory}/{$config.chibi}" class="mt-2 w-full" alt="Chibi!">
        <!-- Chibi end -->
    </div>
    <div class="col-span-7">
        {if $page !== "post"}
            {if $page == "favourites"}
                <h1 class="text-2xl mb-2">{$lang.favourites_of} <a href="profile.php?id={$favouriter._id}"
                        class="text-red-500 hover:text-red-300">{$favouriter.username}</a></h1>
            {/if}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4">
                {foreach from=$posts item=item key=key name=name}
                    <div class="mx-auto">
                        <a href="browse.php?page=post&id={$item["_id"]}"
                            title="{$item.tags} score:{$item.score} rating:{$item.rating}">
                            <img src="{if $item.deleted}assets/img/deleted.png{elseif $item.status == "awaiting"}assets/img/pending.png{else}{$config.db.thumbs.0}/{$item.file.database.thumb}{/if}"
                                alt="If you're reading this, you have JavaScript disabled or try reloading the page"
                                class="img2check mx-auto max-h-[200px] {if $item.deleted || $item.status == "awaiting" || $item.file.orientation == "landscape"}w-[300px] h-auto{else}h-[200px] w-auto{/if} {if $item.file.type.name == "video" && !$item.deleted && $item.status == "active"}border border-blue-500 border-4{elseif $item.deleted}border border-red-500 border-4{elseif $item.status == "awaiting"}border border-orange-500 border-4{/if}">
                        </a>
                    </div>
                {/foreach}
                <div class="col-span-full mx-auto">
                    {if $pagination > 1}
                        <a href="browse.php?page={$page}&{if isset($searchquery)}query={$searchquery}&{/if}{if isset($favouriter._id)}user={$favouriter._id}&{/if}pagination=1"
                            class="text-sm bg-red-500 px-2 text-white hover:bg-red-300 border border-black">
                            &lt;&lt;
                        </a>
                        <a href="browse.php?page={$page}&{if isset($searchquery)}query={$searchquery}&{/if}{if isset($favouriter._id)}user={$favouriter._id}&{/if}pagination={$pagination - 1}"
                            class="text-sm bg-red-500 px-2 text-white hover:bg-red-300 border border-black">
                            &lt;
                        </a>
                    {/if}
                    {foreach from=$pagis item=item key=key name=name}
                        {if $pagination != $item}
                            <a href="browse.php?page={$page}&{if isset($searchquery)}query={$searchquery}&{/if}{if isset($favouriter._id)}user={$favouriter._id}&{/if}pagination={$item}"
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
                        <a href="browse.php?page={$page}&{if isset($searchquery)}query={$searchquery}&{/if}{if isset($favouriter._id)}user={$favouriter._id}&{/if}pagination={$pagination + 1}"
                            class="text-sm bg-red-500 px-2 text-white hover:bg-red-300 border border-black">
                            &gt;
                        </a>
                        <a href="browse.php?page={$page}&{if isset($searchquery)}query={$searchquery}&{/if}{if isset($favouriter._id)}user={$favouriter._id}&{/if}pagination={$totalpages}"
                            class="text-sm bg-red-500 px-2 text-white hover:bg-red-300 border border-black">
                            &gt;&gt;
                        </a>
                    {/if}
                </div>
            </div>
        {else}
            {if $post.deleted}
                <div class="border border-2 border-red-500 p-2">
                    <p>
                        <span class="text-red-500 font-bold">This post has been deleted.</span>
                        Reason:
                        {if !empty($post.deletedReason)}
                            {$post.deletedReason}
                        {else}
                            Unknown.
                        {/if}
                    </p>
                </div>
            {else}
                {if $post.status == "awaiting"}
                    <div class="border border-2 border-red-500 p-2 mb-4">
                        <p>
                            <span class="text-red-500 font-bold">This post is awaiting approval.</span>
                            Reason:
                            {if !empty($post.statusReason)}
                                {$post.statusReason}
                            {else}
                                Unknown.
                            {/if}
                        </p>
                    </div>
                {/if}
                {if $post.file.type.name == "image"}
                    <img src="{$config.db.uploads.0}/{$post.file.database.file}" class="w-auto max-w-full">
                {elseif $post.file.type.name == "video"}
                    <div id="playerContainer">
                        <video id="player" class="w-auto max-w-full" onload="alert('hi');">
                            <source src="{$config.db.uploads.0}/{$post.file.database.file}" type="video/{$post.file.type.ext}">
                            Your browser does not support HTML5 video.
                        </video>
                    </div>

                    <script src="https://cdn.fluidplayer.com/v3/current/fluidplayer.min.js"></script>
                    <script>
                        // fluidPlayer method is global when CDN distribution is used.
                        var player = fluidPlayer(
                            'player', {
                                layoutControls: {
                                    // Parameters to customise the look and feel of the player
                                    primaryColor: "#fc0303",
                                    playButtonShowing: true,
                                    playPauseAnimation: true,
                                    fillToContainer: true,
                                    autoPlay: false,
                                    preload: true,
                                    mute: false,
                                    doubleclickFullscreen: true,
                                    subtitlesEnabled: false,
                                    keyboardControl: true,
                                    layout: 'default',
                                    allowDownload: true,
                                    playbackRateEnabled: true,
                                    allowTheatre: true,
                                    title: false,
                                    loop: true,
                                    controlBar: {
                                        autoHide: true,
                                        autoHideTimeout: 3,
                                        animated: true
                                    },
                                    // theatreSettings: {
                                    //     width: '85%', // Default '100%'
                                    //     height: '80%', // Default '60%'
                                    //     marginTop: 150, // Default 0,
                                    //     horizontalAlign: 'right' // 'left', 'right' or 'center'
                                    // },
                                    // contextMenu: {
                                    //     controls: true,
                                    //     links: [{
                                    //         href: 'https://rule34.xxx',
                                    //         label: 'Rule 34'
                                    //     }]
                                    // },
                                    // showCardBoardView: true,
                                    // showCardBoardJoystick: true
                                },
                                vastOptions: {
                                    adList: [
                                        // {
                                        //     roll: 'postRoll',
                                        //     vastTag: '../vast/vast.xml',
                                        //     adText: 'Consider to Donate to keep us alive <3',
                                        // },
                                        // {
                                        //     roll: 'preRoll',
                                        //     vastTag: '../vast/vast2.xml',
                                        //     adText: 'Consider to Donate to keep us alive <3',
                                        // },
                                        // {
                                        //     roll: 'midRoll',
                                        //     vastTag: '../vast/vast3.xml',
                                        //     adText: 'Advertise videos today on ForgerFiles!',
                                        //     timer: '50%'
                                        // },
                                    ],
                                    skipButtonCaption: 'Skip ad in [seconds] seconds',
                                    skipButtonClickCaption: 'Skip ad <span class="skip_button_icon"></span>',
                                    adText: null,
                                    adTextPosition: 'top left',
                                    adCTATextVast: true,
                                    adCTAText: 'Donate!',
                                    adCTATextPosition: 'bottom right',
                                    vastTimeout: 5000,
                                    showPlayButton: true,
                                    maxAllowedVastTagRedirects: 1,
                                    showProgressbarMarkers: true
                                }
                            }
                        );
                    </script>

                    <script>
                        function adjustVideoHeight(string) {
                            let numbersArray = string.split('x');
                            let video = document.getElementById("playerContainer");
                            if (numbersArray.length === 2) {
                                let firstNumber = parseInt(numbersArray[0]);
                                let secondNumber = parseInt(numbersArray[1]);
                                if (!isNaN(firstNumber) && !isNaN(secondNumber)) {
                                    video.setAttribute("style", "width:" + firstNumber + "px; " + "height:" + secondNumber + "px;");
                                }
                            }
                            return null;
                        }

                        adjustVideoHeight("{$post.file.dimensions}");
                    </script>
                {/if}
            {/if}

            <h1 class="text-xl mt-2">
                {if $userlevel.perms.can_edit_post && !$post.deleted}
                    <span class="cursor-pointer text-red-500 hover:text-red-300"
                        onclick="toggleDiv('editDiv');addClassById('commentDiv','hidden');">{$lang.edit}</span>
                    {if $userlevel.perms.can_comment}|{/if}
                {/if}
                {if $userlevel.perms.can_comment}
                    <span class="cursor-pointer text-red-500 hover:text-red-300"
                        onclick="toggleDiv('commentDiv');addClassById('editDiv','hidden');">{$lang.respond}</span>
                {/if}
            </h1>

            {if !$post.deleted}
                {if $userlevel.perms.can_edit_post}
                    <div id="editDiv" class="mt-2 {if isset($smarty.post.edit) && !empty($error)}{else}hidden{/if}">
                        <form method="POST" name="edit" class="w-full md:w-[600px]">

                            <label for="source">{$lang.source}:</label>
                            <input type="text" id="source" name="source" class="p-0 px-1 mb-1 w-full" value="{$post.source}"><br>

                            <label for="title">{$lang.title}:</label>
                            <input type="text" id="title" name="title" class="p-0 px-1 mb-1 w-full" value="{$post.title}"><br>

                            <label for="search">{$lang.tags}:</label>
                            <p class="text-sm text-gray-700">{$lang.phrases.upload.tags}</p>
                            <textarea required name="tags" id="editSearch" class="w-full min-h-[100px] px-1"
                                onkeyup="doSearch('editSearch', 'editDisplay');">{$post.tags}</textarea><br>
                            <div id="editDisplay" class="w-full px-1"></div>

                            <div class="mb-2">
                                <p>{$lang.rating}:</p>
                                <div>
                                    <div class="flex">
                                        <div class="flex items-center h-5">
                                            <input id="ratingSafe" type="radio" name="rating" value="safe"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300" required
                                                {if $post.rating == "safe"}checked{/if}>
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
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300" required
                                                {if $post.rating == "questionable"}checked{/if}>
                                        </div>
                                        <div class="ml-2 text-sm">
                                            <label for="questionable" class="font-medium text-gray-900">Questionable (Ecchi)</label>
                                            <p class="text-xs font-normal text-gray-500">
                                                No nudity, nipples to some extend okay, etc.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <div class="flex items-center h-5">
                                            <input id="explicit" type="radio" name="rating" value="explicit"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300" required
                                                {if $post.rating == "explicit"}checked{/if}>
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

                            {if $config.captcha.enabled}
                                {if $config.captcha.type == "hcaptcha"}
                                    <div class="h-captcha mt-2 w-full" data-sitekey="{$config.captcha.hcaptcha.sitekey}"></div>
                                {/if}
                            {/if}

                            <button type="submit" name="edit" class="bg-red-500 hover:bg-red-300 text-white p-0 px-2 mt-2 text-sm">
                                {$lang.edit}
                            </button>

                            {if isset($error)}
                                <p class="mt-2"><span class="text-red-500">{$lang.error}:</span> {$error}</p>
                            {/if}
                        </form>
                    </div>
                {/if}
                {if $userlevel.perms.can_comment}
                    <div id="commentDiv" class="mt-2 {if isset($smarty.post.comment) && !empty($error)}{else}hidden{/if}">
                        <form method="POST" name="comment" class="w-full md:w-[600px]">
                            <label for="message">{$lang.message}:</label>
                            <textarea name="commentPost" id="message" class="w-full min-h-[100px] px-1"></textarea><br>

                            {if $config.captcha.enabled}
                                {if $config.captcha.type == "hcaptcha"}
                                    <div class="h-captcha mt-2 w-full" data-sitekey="{$config.captcha.hcaptcha.sitekey}"></div>
                                {/if}
                            {/if}

                            <button type="submit" name="comment"
                                class="bg-red-500 hover:bg-red-300 text-white p-0 px-2 mt-2 text-sm">
                                {$lang.send}
                            </button>

                            {if isset($error)}
                                <p class="mt-2"><span class="text-red-500">{$lang.error}:</span> {$error}</p>
                            {/if}
                        </form>
                    </div>
                {/if}
            {/if}
        {/if}
    </div>
</div>

{include file="part.footer.tpl"}