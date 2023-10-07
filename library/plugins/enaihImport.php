<?php

// this is not for you, don't ever touch this!!

if ($logged && $userlevel["perms"]["can_post"]) {
    if (isset($_GET["action"]) && !empty($_GET["action"]) && clean($_GET["action"]) == "enaihImport") {
        if (strpos($requestUrl, "blank.php") == false) {
            header("Location: blank.php?action=enaihImport&folder={$_GET["folder"]}");
            die("lol");
        }
        echo "Starting importing post...<br>";
        if (isset($_GET["folder"]) && !empty($_GET["folder"])) {
            $folder = clean($_GET["folder"]);
            if (!file_exists(ps(__DIR__ . "/../../public/" . $folder))) {
                die("Specified folder does not exist! Are you sure it is in /public/{$folder}?<br>");
            }

            $files = glob(ps(__DIR__ . "/../../public/" . $folder . "/*.txt"));
            echo "Reading TXT files...<br>";

            // print_r($files);
            if (empty($files)) {
                die("There don't seem to be any files in the folder.");
            }

            require platformSlashes(__DIR__ . "/../getid3/getid3.php");
            require platformSlashes(__DIR__ . "/../claviska/SimpleImage.php");
            $getID3 = new getID3;
            $image = new \claviska\SimpleImage();

            foreach ($files as $txt) {
                $_txt = pathinfo($txt, PATHINFO_FILENAME);
                $content = clean(file_get_contents($txt));
                $tags = explode(",", $content);

                $exists = false;
                foreach ($config["upload"]["allowed"]["img"] as $ext) {
                    if ($exists)
                        break;
                    if (file_exists(ps(__DIR__ . "/../../public/" . $folder . "/" . $_txt . $ext))) {
                        $exists = true;
                        $extension = $ext;
                    }
                }
                if (!$exists)
                    foreach ($config["upload"]["allowed"]["video"] as $ext) {
                        if ($exists)
                            break;
                        if (file_exists(ps(__DIR__ . "/../../public/" . $folder . "/" . $_txt . $ext))) {
                            $exists = true;
                            $extension = $ext;
                        }
                    }

                if ($exists) {

                    // Datei existiert, nun in die DB einsetzen, etc.

                    $currentFile = ps(__DIR__ . "/../../public/" . $folder . "/" . $_txt . $extension);
                    $md5 = hash_file("md5", $currentFile);

                    $md5check = $db["posts"]->findBy(["file.hash", "==", $md5]);
                    echo "Checking if MD5 in DataBase...<br>";

                    if (!empty($md5check)) {
                        echo "MD5 already in Database! Skipping this image...<br>";
                    } else {

                        echo "Success! MD5 not in DataBase.<br>";
                        // Dateigröße ist hier egal, das lasse ich sein.

                        $error = false;
                        $newFilename = genUuid();
                        $file = $getID3->analyze($currentFile);
                        $targetFile = platformSlashes($config["db"]["uploads"][1] . "/" . $newFilename . $extension);
                        $finalFile = $newFilename . $extension;

                        if (in_array($extension, $config["upload"]["allowed"]["img"])) {
                            $fileArrayType = "image";
                            list($dim_width, $dim_height) = getimagesize($currentFile);
                            $dimensions = $dim_width . "x" . $dim_height;
                        } elseif (in_array($extension, $config["upload"]["allowed"]["video"])) {
                            $fileArrayType = "video";
                            $dimensions = $file["video"]["resolution_x"] . "x" . $file["video"]["resolution_y"];
                        } else {
                            echo "Invalid file format. Skipping this file.<br>";
                            $error = true;
                        }

                        if (!$error) {
                            $fileSize = filesize($currentFile);
                            if (!rename($currentFile, $targetFile)) {
                                echo "File could not be moved. Skipping this file.<br>";
                                // Lieber nicht...
                                // unlink($tmpPut);
                                // unlink($tmpPutThumb);
                            } else {
                                echo "Success!<br>";

                                // Processing for thumbnail
                                echo "Processing thumbnail...<br>";

                                if ($fileArrayType == "image") {
                                    try {
                                        $image
                                            ->fromFile($targetFile)
                                            ->bestFit($config["thumbnail"]["height"], $config["thumbnail"]["width"])
                                            ->toFile(platformSlashes($config["db"]["thumbs"][1] . "/" . $newFilename . $extension), 'image/png');
                                    } catch (Exception $err) {
                                        // Handle errors
                                        $smarty->assign("error", "Thumbnail creation: " . $err->getMessage());
                                        $error = true;
                                    }
                                } elseif ($fileArrayType == "video") {
                                    $ffmpeg = platformSlashes(__DIR__ . "/../library/ffmpeg/bin/ffmpeg.exe");
                                    $video = platformSlashes($targetFile);
                                    $image = platformSlashes($config["db"]["thumbs"][1] . "/" . $newFilename . ".jpeg");
                                    $interval = 1;
                                    $size = '320x240';
                                    $cmd = "{$ffmpeg} -i {$video} -vf scale='min(300,iw)':-1 -an -ss {$interval} -f mjpeg -t 1 -r 1 -y $image 2>&1";
                                    $return = `$cmd`;
                                }

                                if ($error) {
                                    // Lieber nicht...
                                    // unlink($targetFile);
                                    // unlink($tmpPutThumb);
                                    echo "Error! Could not move thumbnail.";
                                } else {
                                    echo "Success!<br>";

                                    // Prepare post for inserting into DB
                                    echo "Success! Preparing for insert in DataBase...<br>";
                                    // Das Rating MUSS safe sein... sonst naja. ich bin zu faul.
                                    $rating = "safe";

                                    $data = array(
                                        "source" => "",
                                        "title" => "",
                                        "tags" => "",
                                        "rating" => $rating,
                                        "score" => 0,
                                        "file" => array(
                                            "name" => $finalFile,
                                            "hash" => null,
                                            "type" => array(
                                                "ext" => $extension,
                                                "name" => $fileArrayType
                                            ),
                                            "dimensions" => $dimensions,
                                            "size" => $fileSize,
                                            "database" => array(
                                                "file" => $newFilename . $extension,
                                                "thumb" => $newFilename . ($fileArrayType == "video" ? ".jpeg" : $extension)
                                            ),
                                            "orientation" => isLandsape($config["db"]["thumbs"][1] . "/" . $newFilename . ($fileArrayType == "video" ? ".jpeg" : $extension))
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
                                        $tags = altProcessTags($post["_id"], $tags);
                                        $fileHash = hash_file("md5", $targetFile);
                                        $data["tags"] = trim($tags);
                                        $data["file"]["hash"] = $fileHash;
                                        $db["posts"]->updateById($post["_id"], $data);
                                    } else {
                                        echo "Error! The server messed up.";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
