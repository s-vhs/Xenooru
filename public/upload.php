<?php

require "../autoload.php";
if (!$logged) header("Location: account.php?tab=login") && die("not logged in.");

$pages["isBrowse"] = true;
$smarty->assign("pages", $pages);
$smarty->assign("pagetitle", $lang["upload"]);

if (isset($_POST["upload"])) {
    require platformSlashes(__DIR__ . "/../library/getid3/getid3.php");
    $getID3 = new getID3;
    $error = false;
    if (!isset($_POST["acceptToS"])) $error = true && $smarty->assign("error", "You must read and comply with the Terms of Service!");
    if (!isset($_POST["acceptPrivacy"])) $error = true && $smarty->assign("error", "You must read and comply with the Privacy Policy!");
    if (!$error) {
        if (isset($_POST["rating"])) {
            switch ($_POST["rating"]) {
                case "questionable":
                    $rating = "questionable";
                    break;
                case "explicit":
                    $rating = "explicit";
                    break;
                default:
                    $rating = "safe";
            }
            $source = $_POST["source"];
            $title = $_POST["title"];
            $tags = processTags($_POST["tags"]);

            // Nun beginnt die Bildverarbeitung
            if (!empty($_FILES["file"]["tmp_name"])) {
                if ($_FILES["file"]["size"] > $config["upload"]["max"]) {
                    doLog("upload", false, "file too large.", $user["_id"]);
                    $smarty->assign("error", "File too large!");
                } else {
                    $newFilename = genUuid();
                    $fileName = basename($_FILES["file"]["name"]);
                    $fileType = strtolower(pathinfo(basename($_FILES["file"]["name"]), PATHINFO_EXTENSION));
                    $fileTypeWithDot = "." . $fileType;
                    $file = $getID3->analyze($_FILES["file"]["tmp_name"]);
                    $targetFile = platformSlashes($config["db"]["uploads"][1] . "/" . $newFilename . $fileTypeWithDot);
                    $finalFile = $newFilename . $fileTypeWithDot;
                    if (in_array($fileTypeWithDot, $config["upload"]["allowed"]["img"])) {
                        $fileArrayType = "image";
                        list($dim_width, $dim_height) = getimagesize($_FILES["file"]["tmp_name"]);
                        $dimensions = $dim_width . "x" . $dim_height;
                    } elseif (in_array($fileTypeWithDot, $config["upload"]["allowed"]["video"])) {
                        $fileArrayType = "video";
                        $dimensions = $file["video"]["resolution_x"] . "x" . $file["video"]["resolution_y"];
                    } else {
                        $smarty->assign("error", "Unsupported file format!");
                        $error = true;
                    }
                    if (!$error) {
                        $fileSize = $file["filesize"];
                        if (!move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                            doLog("upload", false, "file could not be uploaded.", $user["_id"]);
                            $smarty->assign("error", "File could not be uploaded!");
                        } else {
                            if ($fileArrayType == "image") {
                                try {
                                    require platformSlashes(__DIR__ . "/../library/claviska/SimpleImage.php");
                                    $image = new \claviska\SimpleImage();
                                    $image
                                        ->fromFile($targetFile)
                                        ->bestFit($config["thumbnail"]["height"], $config["thumbnail"]["width"])
                                        ->toFile(platformSlashes($config["db"]["thumbs"][1] . "/" . $newFilename . $fileTypeWithDot), 'image/png');
                                    doLog("upload", true, "file uploaded, thumbail created.", $user["_id"]);
                                } catch (Exception $err) {
                                    // Handle errors
                                    doLog("upload", false, "error at thumbnail creation: " . $erro->getMessage(), $user["_id"]);
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

                            if (!$error) {
                                $data = array(
                                    "source" => $source,
                                    "title" => $title,
                                    "tags" => $tags,
                                    "rating" => $rating,
                                    "score" => 0,
                                    "file" => array(
                                        "name" => $fileName,
                                        "type" => array(
                                            "ext" => $fileType,
                                            "name" => $fileArrayType
                                        ),
                                        "dimensions" => $dimensions,
                                        "size" => $fileSize,
                                        "database" => array(
                                            "file" => $newFilename . $fileTypeWithDot,
                                            "thumb" => $newFilename . ($fileArrayType == "video" ? ".jpeg" : $fileTypeWithDot)
                                        ),
                                        "orientation" => isLandsape($targetFile)
                                    ),
                                    "user" => $user["_id"],
                                    "status" => "active",
                                    "deleted" => false,
                                    "deletedReason" => null,
                                    "timestamp" => now()
                                );
                                $post = $db["posts"]->insert($data);
                                header("Location: browse.php?post={$post["_id"]}");
                            }
                        }
                    } else {
                        doLog("upload", false, "unsupported file format.", $user["_id"]);
                    }
                }
            } else {
                doLog("upload", false, "no image given.", $user["_id"]);
            }
        } else {
            doLog("upload", false, "no rating given.", $user["_id"]);
        }
    } else {
        doLog("upload", false, "failed to comply with tos or privacy policy.", $user["_id"]);
    }
}

$smarty->display("part.top.tpl");
$smarty->display("page.upload.tpl");
$smarty->display("part.bottom.tpl");
