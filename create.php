<?php
require("connect.php");

require("image.php");

//create variables
$name = "";
$event = "";
$image = "";

$errorMessage = "";
$successMessage = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST["name"];
    $event = $_POST["event"];
    $imgpath = image_upload($_FILES['image']);

    do {
        if (empty($name) || empty($event)) {
            $errorMessage = "ALL THE FIELDS ARE REQUIRED !";
            break;
        }

        //add new client to database
        $sql = "INSERT INTO employee(name,event,image)" .
            "VALUES ('$name', '$event','$imgpath')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: ";
            break;
        }

        $name = "";
        $event = "";
        $image = "";

        $successMessage = "CLIENT ADDED SUCCESSFULLY";

        header("location: /crud/index.php");
        exit;
    } while (false);
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
        <h2>New Client</h2>

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

        <form method="post" enctype="multipart/form-data">
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
                <div class="input-group mb-3">
                    <input type="file" class="form-control" name="image" accept=".jpg,.png,.jpeg" value="<?php echo $image; ?>">
                    <label class="input-group-text" name="image">Image</label>
                </div>
            </div>

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
            <br />
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-danger" href="/crud/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>

</body>

</html>