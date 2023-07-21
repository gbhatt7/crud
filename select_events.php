<?php
// Connect to the MySQL database (change these settings to your database configuration)
require("connect.php");

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Function to fetch events from the database
function getEventsFromDatabase($connection) {
    $sql = "SELECT * FROM `event`";
    $result = $connection->query($sql);

    $events = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
    }
    return $events;
}

// Display the events form
function displayEventsForm($events) {
    echo '<form action="process_form.php" method="post">';
    foreach ($events as $event) {
        echo '<label><input type="checkbox" ename="events[]" value="' . $event['id'] . '"> ' . $event['ename'] . '</label><br>';
    }
    echo '<input type="submit" value="Submit">';
    echo '</form>';
}

$events = getEventsFromDatabase($connection);
if (!empty($events)) {
    displayEventsForm($events);
} else {
    echo "No events found.";
}

$connection->close();
?>
