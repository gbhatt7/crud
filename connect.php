<?php

$connection = mysqli_connect("localhost", "root", "", "myshop");

if (mysqli_connect_errno()) {
    die("Cannot connect to database" . mysqli_connect_errno());
}

?>
