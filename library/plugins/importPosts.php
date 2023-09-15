<?php

if (!file_exists(ps(__DIR__ . "/data/import_urls.php")))
    die("Error: No import_urls.php file for plugin importPosts found.");
else
    require ps(__DIR__ . "/data/import_urls.php");

if ($logged && $userlevel["perms"]["can_post"]) {
    if (isset($_GET["action"]) && !empty($_GET["action"]) && clean($_GET["action"]) == "importPost") {
        echo "Starting importing post...<br>";
        if (isset($_GET["source"]) && !empty($_GET["source"]) && in_array(clean($_GET["source"]), $importUrls)) {
            echo "Getting source...<br>";
            if (isset($_GET["pid"]) && !empty($_GET["pid"]) && is_numeric($_GET["pid"])) {
                echo "Getting post id...<br>";
                $pid = stripNumbers($_GET["pid"]);
                $importUrl = clean($_GET["source"]);

                foreach ($importMethods as $im) {
                    if ($im["name"] == $importUrl)
                        $importMethod = $im;
                    break;
                }

                switch ($importMethod["type"]) {
                    case "gelbooru_beta_0-2-0":
                        echo "Case: 'gelbooru_beta_0-2-0<br>";
                        // Get everything right
                        $fullUrl = $importMethod["api"] . $pid;

                        // Call the API and process results
                        $request = callAPI($fullUrl);
                        $xml = simplexml_load_string($request, "SimpleXMLElement", LIBXML_NOCDATA);
                        $json = je($xml);
                        $result = jd($json);

                        // Saving the base file to a temporary folder for processing
                        // print_r($result); // For debugging I guess?
                        if (empty($result["post"])) {
                            echo "Error! Post does not exist (yet).";
                        }
                        $fileName = basename($result["post"]["@attributes"]["file_url"]);
                        $fileType = getFileExtension($fileName);
                        $thumbFileName = basename($result["post"]["@attributes"]["preview_url"]);
                        $thumbFileType = getFileExtension($thumbFileName);

                        // Create TMP folder if not exists
                        if (!file_exists(ps(__DIR__ . "/../../public/community/tmp")))
                            mkdir(ps(__DIR__ . "/../../public/community/tmp"), 0755, true);
                        $tmpPut = ps(__DIR__ . "/../../public/community/tmp/" . $fileName);
                        $tmpPutThumb = ps(__DIR__ . "/../../public/community/tmp/" . $thumbFileName);

                        // First check MD5
                        $md5 = $result["post"]["@attributes"]["md5"];
                        // $md5check = $db["posts"]->findBy(["file.hash", "==", $md5]);
                        $md5check = "";
                        echo "Checking if MD5 in DataBase...<br>";

                        if (empty($md5check)) {
                            echo "Success! MD5 not in DataBase.<br>";
                            // MD5 not in DB
                            // Download and put into TMP path
                            echo "Downloading posts. This may take a while...<br>";
                            if (file_put_contents($tmpPut, file_get_contents($result["post"]["@attributes"]["file_url"])) && file_put_contents($tmpPutThumb, file_get_contents($result["post"]["@attributes"]["preview_url"]))) {
                                // Success!
                                echo "Success! Post and Thumbnail downloaded.<br>";
                                require platformSlashes(__DIR__ . "/../getid3/getid3.php");
                                $getID3 = new getID3;

                                // Processing for main file
                                echo "Processing main file...<br>";
                                $fileType = getFileType($tmpPut);

                                // Check filesize
                                if (filesize($tmpPut) > $config["upload"]["max"]) {
                                    echo "Error! File too large.<br>";
                                    doLog("importPost", false, "file too large.", $user["_id"]);
                                } else {
                                    // Checking file format
                                    $error = false;
                                    $newFilename = genUuid();
                                    $fileTypeWithDot = "." . $fileType["extension"];
                                    $file = $getID3->analyze($tmpPut);
                                    $targetFile = platformSlashes($config["db"]["uploads"][1] . "/" . $newFilename . $fileTypeWithDot);
                                    $finalFile = $newFilename . $fileTypeWithDot;
                                    if (in_array($fileTypeWithDot, $config["upload"]["allowed"]["img"])) {
                                        $fileArrayType = "image";
                                        list($dim_width, $dim_height) = getimagesize($tmpPut);
                                        $dimensions = $dim_width . "x" . $dim_height;
                                    } elseif (in_array($fileTypeWithDot, $config["upload"]["allowed"]["video"])) {
                                        $fileArrayType = "video";
                                        $dimensions = $file["video"]["resolution_x"] . "x" . $file["video"]["resolution_y"];
                                    } else {
                                        doLog("importPost", false, "invalid file format.", $user["_id"]);
                                        $error = true;
                                    }

                                    if (!$error) {
                                        $fileSize = filesize($tmpPut);
                                        if (!rename($tmpPut, $targetFile)) {
                                            doLog("importPost", false, "file could not be moved.", $user["_id"]);
                                            echo "Error! Could not be moved for some reason.";
                                            unlink($tmpPut);
                                            unlink($tmpPutThumb);
                                        } else {
                                            echo "Success!<br>";

                                            // Processing for thumbnail
                                            echo "Processing thumbnail...<br>";
                                            $thumbFileType = getFileType($tmpPutThumb);
                                            $targetFileThumb = platformSlashes($config["db"]["thumbs"][1] . "/" . $newFilename . "." . $thumbFileType["extension"]);
                                            if (!rename($tmpPutThumb, $targetFileThumb)) {
                                                unlink($targetFile);
                                                unlink($tmpPutThumb);
                                                echo "Error! Could not move thumbnail.";
                                            } else {
                                                echo "Success!<br>";

                                                // Prepare post for inserting into DB
                                                echo "Success! Preparing for insert in DataBase...<br>";
                                                switch ($result["post"]["@attributes"]["rating"]) {
                                                    case "q":
                                                        $rating = "questionable";
                                                        break;
                                                    case "e":
                                                        $rating = "explicit";
                                                        break;
                                                    default:
                                                        $rating = "safe";
                                                }

                                                $data = array(
                                                    "source" => $result["post"]["@attributes"]["source"],
                                                    "title" => "",
                                                    "tags" => "",
                                                    "rating" => $rating,
                                                    "score" => 0,
                                                    "file" => array(
                                                        "name" => $finalFile,
                                                        "hash" => null,
                                                        "type" => array(
                                                            "ext" => $fileType["extension"],
                                                            "name" => $fileArrayType
                                                        ),
                                                        "dimensions" => $dimensions,
                                                        "size" => $fileSize,
                                                        "database" => array(
                                                            "file" => $newFilename . $fileTypeWithDot,
                                                            "thumb" => $newFilename . ($fileArrayType == "video" ? ".jpeg" : "." . $thumbFileType["extension"])
                                                        ),
                                                        "orientation" => isLandsape($config["db"]["thumbs"][1] . "/" . $newFilename . ($fileArrayType == "video" ? ".jpeg" : "." . $thumbFileType["extension"]))
                                                    ),
                                                    "user" => $user["_id"],
                                                    "username" => $user["username"],
                                                    "status" => "active",
                                                    "deleted" => false,
                                                    "deletedReason" => null,
                                                    "timestamp" => now()
                                                );
                                                $post = $db["posts"]->insert($data);
                                                if ($post) {
                                                    $tags = altProcessTags($post["_id"], clean($result["post"]["@attributes"]["tags"]));
                                                    $fileHash = hash_file("md5", $targetFile);
                                                    $data["tags"] = trim($tags);
                                                    $data["file"]["hash"] = $fileHash;
                                                    $db["posts"]->updateById($post["_id"], $data);
                                                    die(print_r($result["post"]["@attributes"]["tags"]));
                                                } else {
                                                    echo "Error! The server messed up.";
                                                    doLog("upload", false, "inserting data failed.", $user["_id"]);
                                                }
                                            }
                                        }
                                    }
                                }
                            } else {
                                doLog("importPost", false, "downloading went wrong: " . $result["post"]["@attributes"]["file_url"], $user["_id"]);
                                echo "Error! Something went wrong while downloading.<br>";
                            }
                        } else {
                            echo "Error! MD5 already in DataBase.<br>";
                            doLog("importPost", false, "md5 already in db: " . $md5, $user["_id"]);
                        }

                        break;
                    default:
                        doLog("importPost", false, "no handler implemented or found.", $user["_id"]);
                        echo "Import cancelled! No handler for given method implemented.<br>";
                        break;
                }
            } else {
                echo "Import canceled! Missing or invalid post id.<br>";
            }
        } else {
            echo "Import canceled! Missing or invalid source.<br>";
        }
    }
}
