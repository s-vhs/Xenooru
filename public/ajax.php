<?php

require "../autoload.php";

if (isset($_POST["search"])) {
    $_tag = array_reverse(explode(" ", $_POST["search"]));
    $_tag = $_tag[0];
    echo "<ul class=\"text-sm\">";
    if (strlen($_tag) > 2) {
        $tags = $db["tags"]->createQueryBuilder()
            ->search(["name"], $_tag)
            ->orderBy(["name" => "ASC"]) // sort result
            ->getQuery()
            ->fetch();
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                if ($tag["order"] == 1)
                    $color = "fuchsia";
                elseif ($tag["order"] == 2)
                    $color = "lime";
                elseif ($tag["order"] == 3)
                    $color = "indigo";
                elseif ($tag["order"] == 4)
                    $color = "red";
                else
                    $color = "orange";
                echo "<li onclick=\"fill('" . substr($tag["name"], strlen($_tag)) . " ')\" class=\"text-" . $color . "-500 cursor-pointer\">" . str_replace("_", " ", $tag["name"]) . " (" . count($db["tagRelations"]->findBy(["name", "=", $tag["name"]])) . ")</li>";
            }
        } else {
            echo "<li>Nothing found...</li>";
        }
    } else {
        echo "<li>At least two characters...</li>";
    }
    echo "</ul>";
}
