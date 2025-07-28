<?php
// Include config file
require_once "../config.php";

// Check if the ID parameter is set in the URL
if (isset($_GET['id'])) {
    // Get the ID from the URL and sanitize it
    $id = intval($_GET['id']);

    // Disable foreign key checks (if applicable)
    $disableForeignKeySQL = "SET FOREIGN_KEY_CHECKS=0;";
    mysqli_query($link, $disableForeignKeySQL);

    // Construct the DELETE query
    $deleteSQL = "DELETE FROM creditors WHERE ID = '" . $id . "';";

    // Execute the DELETE query
    if (mysqli_query($link, $deleteSQL)) {
        // Creditor successfully deleted, redirect back to the main page
        header("location: ../panel/creditor-panel.php");
        exit();
    } else {
        // Error occurred during execution, display an error message
        echo "Error: " . mysqli_error($link);
    }

    // Enable foreign key checks (if applicable)
    $enableForeignKeySQL = "SET FOREIGN_KEY_CHECKS=1;";
    mysqli_query($link, $enableForeignKeySQL);

    // Close the connection
    mysqli_close($link);
} else {
    // If no ID is provided, redirect to the creditor panel
    header("location: ../panel/creditor-panel.php");
    exit();
}
?>