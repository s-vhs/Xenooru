<?php

function platformSlashes($path)
{
    return str_replace('/', DIRECTORY_SEPARATOR, $path);
}

function genToken()
{
    return md5(rand());
}

function now()
{
    return date("d-m-y h:i:s");
}
