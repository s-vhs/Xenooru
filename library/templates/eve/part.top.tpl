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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="assets/{$theme.directory}/eve.js"></script>
    {if $config.captcha.enabled}
        {if $config.captcha.type == "hcaptcha"}
            <script src='https://www.hCaptcha.com/1/api.js' async defer></script>
        {/if}
    {/if}
</head>

<body>