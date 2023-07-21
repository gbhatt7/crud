<?php
// Connect to the MySQL database (change these settings to your database configuration)
require("connect.php");

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected events from the form
    if (isset($_POST['events']) && is_array($_POST['events'])) {
        $selectedEvents = $_POST['events'];
        $events = implode(',', $selectedEvents); // Convert selected events to a comma-separated string

        // Assuming you have the employee ID available in your form (e.g., as a hidden field)
        $id = $_GET["id"]; // Replace with your actual employee ID

        // Update the "event" column in the "employee" table
        $sql = "UPDATE employee SET `event` = '$events' WHERE `id` = $id";

        if ($connection->query($sql) === TRUE) {
            echo "Events updated successfully!";
        } else {
            echo "Error updating events: " . $connection->error;
        }
    }
}

header('')
?>
