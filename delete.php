<?php

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    require("connect.php");
    require("image.php");

    $query = "SELECT * FROM `employee` WHERE `id` = '$_GET[id]'";
    $result = mysqli_query($connection, $query);
    $fetch = mysqli_fetch_assoc($result);

    image_remove($fetch['image']);

    $sql = "DELETE FROM employee WHERE id=$id";
    $connection->query($sql);
};

header("location: /crud/index.php");
exit;

?>
