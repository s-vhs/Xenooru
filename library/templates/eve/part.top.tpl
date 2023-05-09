<!DOCTYPE html>
<html lang="{$userlang}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.5/dist/flowbite.min.css" type="text/css">
    <link rel="stylesheet" href="assets/animate.css" type="text/css">
    <title>{$config.title} - {$pagetitle}</title>
    <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pace-js@latest/pace-theme-default.min.css">
    <link rel="stylesheet" href="assets/{$theme.directory}/eve.css" type="text/css">
    <script type="text/javascript" src="assets/{$theme.directory}/eve.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    {if $config.captcha.enabled}
        {if $config.captcha.type == "hcaptcha"}
            <script src='https://www.hCaptcha.com/1/api.js' async defer></script>
        {/if}
    {/if}

    <link rel="apple-touch-icon" sizes="180x180" href="assets/{$theme.directory}/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/{$theme.directory}/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/{$theme.directory}/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/{$theme.directory}/favicon/site.webmanifest">

    {if isset($page)}
        {if $page == "post"}
            <link rel="stylesheet" href="https://cdn.plyr.io/3.7.3/plyr.css">
        {/if}
    {/if}
</head>

<body>