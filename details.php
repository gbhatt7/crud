<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <style>
        td {
            width: 50%;
        }

        tr {
            text-align: center;
        }
    </style>
</head>

<body style="text-align: center;">
    <h1><b>Employee Details</b></h1>
    <table width="100%" border="1">
        <tr>
            <td><b>Employee ID</b></td>
            <td><?= $row['id'] ?></td>
        </tr>
        <tr>
            <td><b>Name</b></td>
            <td><?= $row['name'] ?></td>
        </tr>
        <tr>
            <td><b>Image</b></td>
            <td>
                <?php
                require('image.php');
                $fetch_src = FETCH_SRC;
                $imagePath = $fetch_src . $row['image'];
                echo "$imagePath";
                ?>
                <br>
                <?php echo "<img src='$fetch_src$row[image]' width='200px' height='200px'>" ?>
            </td>
        </tr>
    </table>
    <br>
    <h2>Event Table</h2>
    <table width="100%" border="1">
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
                            <tr class='align-middle' style='text-align: center;'>
                            <td>{$cell}</td>
                            <td>{$event_row['ename']}</td>
                            </tr>";
                }
            }
            ?>
        </tbody>
    </table>
    <br>
</body>

</html>