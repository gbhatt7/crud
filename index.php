<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <h2>List of Clients</h2>
        <div class="row">
            <div class="sm-3 col-sm-3 d-grid">
                <a class="btn btn-primary" href="/gaurav/crud/create.php" role="button">New Client</a>
            </div>
        </div>
        <br>
        <div class="input-group mt-3 mb-3">
            <input type="text" id="search" name="search" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="search..">
        </div>
        <table class="table" id="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Event ID</th>
                    <th>Event Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <?php
                require("connect.php");

                require("image.php");

                // Read all rows from the database table
                $sql = "SELECT * FROM `employee`";
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
                    }
                    echo "
                    <tr class='align-middle'>
                    <td>{$row['id']}</td>
                    <td><img src='$fetch_src$row[image]' width='150px' height='150px'></td>
                    <td>{$row['name']}</td>
                    <td>{$row['event']}</td>
                    <td>";
                    echo implode(', ', $myArray);
                    echo "</td>
                    <td>
                        <a target='_blank' class='btn btn-success btn-sm' href='/gaurav/crud/print.php?id=$row[id]'>Print Details</a>
                        <a class='btn btn-primary btn-sm' href='/gaurav/crud/edit.php?id={$row['id']}'>Edit</a>
                        <a class='btn btn-danger btn-sm' href='/gaurav/crud/delete.php?id={$row['id']}'>Delete</a>
                    </td>
                </tr>";
                }
                ?>



            </tbody>
        </table>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script src="index.js"></script>

</html>