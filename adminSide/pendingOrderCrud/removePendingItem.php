<?php
session_start();
require_once '../config.php';

if (isset($_GET['order_id']) && isset($_GET['item_id'])) {
    // Retrieve order_id and item_id from the URL
    $order_id = $_GET['order_id'];
    $item_id = $_GET['item_id'];

    // Validate input
    if (empty($order_id) || empty($item_id)) {
        die("Invalid request.");
    }

    // Delete the item from PendingOrderItems
    $delete_query = "DELETE FROM PendingOrderItems WHERE order_id = '$order_id' AND item_id = '$item_id'";

    if (mysqli_query($link, $delete_query)) {
        // Redirect back to the pending order view page
        header("Location: viewPendingOrder.php?order_id=$order_id");
        exit();
    } else {
        // Handle database error
        die("Failed to remove item: " . mysqli_error($link));
    }
} else {
    // Redirect if accessed directly without required parameters
    header("Location: ../pendingOrders.php");
    exit();
}
?>