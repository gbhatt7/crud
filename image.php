<?php

define("UPLOAD_SRC", $_SERVER['DOCUMENT_ROOT'] . "/gaurav/crud/uploads/");

define("FETCH_SRC", "http://127.0.0.1/gaurav/crud/uploads/");

$fetch_src = FETCH_SRC;

function image_upload($img)
{
    $tmp_loc = $img['tmp_name'];
    $new_name = random_int(0, 99999) . $img['name'];

    $new_loc = UPLOAD_SRC . $new_name;

    if (!move_uploaded_file($tmp_loc, $new_loc)) {
        header("location: index.php?alert=img_upload");
        exit;
    } else {
        return $new_name;
    }
}

function image_remove($img)
{
    if (!unlink(UPLOAD_SRC . $img)) {
        header("location: index.php?alert=img_rem_failed");
        exit;
    } else {
        echo ("$img has been deleted");
    }
}

?>
