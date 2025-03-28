<?php
// Include config file
require_once "../config.php";

// Check if the ItemID parameter is set in the URL
if (isset($_GET['id'])) {
    // Get the ItemID from the URL and sanitize it
    $itemID = intval($_GET['id']);

    // Disable foreign key checks (if applicable)
    $disableForeignKeySQL = "SET FOREIGN_KEY_CHECKS=0;";
    mysqli_query($link, $disableForeignKeySQL);

    // Construct the DELETE query
    $deleteSQL = "DELETE FROM stock WHERE ItemID = '" . $itemID . "';";

    // Execute the DELETE query
    if (mysqli_query($link, $deleteSQL)) {
        // Stock item successfully deleted, redirect back to the main page
        header("location: ../panel/stock-panel.php");
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
    // If no ItemID is provided, redirect to the stock panel
    header("location: ../panel/stock-panel.php");
    exit();
}
?>