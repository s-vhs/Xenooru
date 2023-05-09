<?php

$importUrls = array(
    "safebooru.org",
    "rule34.xxx"
);

$importMethods = array(
    array(
        "name" => "safebooru.org",
        "api" => "https://safebooru.org/index.php?page=dapi&s=post&q=index&id=",
        "type" => "gelbooru_beta_0-2-0"
    ), array(
        "name" => "rule34.xxx",
        "api" => "https://api.rule34.xxx/index.php?page=dapi&s=post&q=index&id=",
        "type" => "gelbooru_beta_0-2-0"
    )
);
