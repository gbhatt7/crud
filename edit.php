<?php

require("connect.php");
require("image.php");

$id = "";
$name = "";
$event = "";
$image = "";
$editimage = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //show data

    if (!isset($_GET["id"])) {
        header("location: /gaurav/crud/index.php");
        exit;
    }

    $id = $_GET["id"];

    //read data
    $sql = "SELECT * FROM employee WHERE id=$id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: /gaurav/crud/index.php");
        exit;
    }

    $name = $row["name"];
    $event = $row["event"];
    $image = $row["image"];
    
} else {
    if(!empty($editimage)){
    //update data
    $id = $_POST["id"];
    $name = $_POST["name"];
    $event = $_POST["event"];
    $imgpath = image_upload($_FILES['editimage']);

    do {

        if (empty($name) || empty($event) || empty($image)) {
            $errorMessage = "ALL THE FIELDS ARE REQUIRED !";
            break;
        }
            $query = "SELECT * FROM `employee` WHERE `id` = '$id'";
            $result = mysqli_query($connection, $query);
            $fetch = mysqli_fetch_assoc($result);
        
            image_remove($fetch['image']);
        //add new client to database
        $sql = "UPDATE employee " .
            "SET name='$name', event='$event', image='$imagePath'" .
            "WHERE id=$id";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: ";
            break;
        }

        $successMessage = "CLIENT UPDATED SUCCESSFULLY";

        header("location: /gaurav/crud/index.php");
        exit;

    } while (true);
    } else{
        //update data
    $id = $_POST["id"];
    $name = $_POST["name"];
    $event = $_POST["event"];
    $image = $_POST["image"];

    do {

        if (empty($name) || empty($event)) {
            $errorMessage = "ALL THE FIELDS ARE REQUIRED !";
            break;
        }

        //add new client to database
        $sql = "UPDATE employee " .
            "SET name='$name', event='$event', image='$image' " .
            "WHERE id=$id";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: ";
            break;
        }

        $successMessage = "CLIENT UPDATED SUCCESSFULLY";

        header("location: /gaurav/crud/index.php");
        exit;
    } while (true);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container my-5">
        <h2>Update Client</h2>

        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="col-md-6">
                <div class="row mb-3">
                    <label for="name" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="event" class="col-sm-3 col-form-label">Event</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="event" value="<?php echo $event; ?>">
                    </div>
                </div>
                <?php echo "<img src='$fetch_src$row[image]' width='200px' height='200px'>" ?>
                <br>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" name="image" accept=".jpg,.png,.jpeg" value="<?php echo $editimage; ?>">
                    <label class="input-group-text" name="image">Image</label>
                </div>
            </div>
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>Event ID</th>
                        <th>Event Name</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    require("connect.php");

                    // Read all rows from the database table
                    $sql = "SELECT * FROM `employee` WHERE id=$id";
                    $result = $connection->query($sql);

                    if (!$result) {
                        die("Invalid query: ");
                    }

                    // Read data of each row
                    while ($row = $result->fetch_assoc()) {
                        $eventname = explode(',', $row['event']);

                        // Create an array to store event names
                        $myArray = array();

                        // Fetch event names from the "event" table
                        foreach ($eventname as $cell) {
                            $sql_event = "SELECT * FROM `event` WHERE id='$cell'";
                            $result_event = $connection->query($sql_event);
                            $event_row = $result_event->fetch_assoc();

                            // Check if the event exists in the "event" table before adding it to the array
                            if ($event_row) {
                                $myArray[] = $event_row['ename'];
                            }
                            echo "
                            <tr class='align-middle'>
                            <td>{$cell}</td>
                            <td>{$event_row['ename']}</td>
                            </tr>";
                        }
                    }
                    ?>



                </tbody>
            </table>
            <?php
            if (!empty($successMessage)) {
                echo "
                <div class='row mb-3'>
                <div class='offset-sm-3 col-sm-3 d-grid'>
                    <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>$successMessage</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                </div>
            </div>
            ";
            }
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-danger" href="/gaurav/crud/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>

</body>

</html>