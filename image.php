<?php

define("UPLOAD_SRC", $_SERVER['DOCUMENT_ROOT'] . "/crud/uploads/");

define("FETCH_SRC", "http://127.0.0.1/crud/uploads/");

$fetch_src = FETCH_SRC;
function image_upload($img)
{
    $tmp_loc = $img['tmp_name'];
    $new_name = random_int(0, 99999) . $img['name'];

    $new_loc = UPLOAD_SRC . $new_name;

    move_uploaded_file($tmp_loc, $new_loc);
}

function image_remove($img)
{
    if (!unlink(UPLOAD_SRC . $img)) {
        header("location: index.php?alert=img_rem_failed");
        exit;
    } else {
    }
}

?>
