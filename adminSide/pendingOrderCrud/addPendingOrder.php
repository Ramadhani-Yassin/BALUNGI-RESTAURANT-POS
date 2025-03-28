<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $_POST['customer_name'];
    $order_date = date('Y-m-d H:i:s');

    // Insert the pending order without a bill_id
    $insert_query = "INSERT INTO PendingOrders (customer_name, order_date, status) 
                     VALUES ('$customer_name', '$order_date', 'Pending')";
    if (mysqli_query($link, $insert_query)) {
        $order_id = mysqli_insert_id($link);
        header("Location: ../panel/pendingOrders.php");
        exit();
    } else {
        echo "<script>alert('Failed to create pending order: " . mysqli_error($link) . "');</script>";
    }
}
?>