<?php
session_start(); // Ensure session is started
require_once '../config.php';
include '../inc/dashHeader.php';

// Handle actions (close or delete pending order)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    if ($_GET['action'] === 'close') {
        // Close the pending order and create a bill
        $customer_name_query = "SELECT customer_name FROM PendingOrders WHERE order_id = '$order_id'";
        $customer_name_result = mysqli_query($link, $customer_name_query);
        $customer_name_row = mysqli_fetch_assoc($customer_name_result);
        $customer_name = $customer_name_row['customer_name'];

        // Create a new bill
        $bill_time = date('Y-m-d H:i:s');
        $insert_bill_query = "INSERT INTO Bills (customer_name, bill_time) VALUES ('$customer_name', '$bill_time')";
        if (mysqli_query($link, $insert_bill_query)) {
            $bill_id = mysqli_insert_id($link);

            // Fetch items from the pending order
            $items_query = "SELECT * FROM PendingOrderItems WHERE order_id = '$order_id'";
            $items_result = mysqli_query($link, $items_query);

            if ($items_result && mysqli_num_rows($items_result) > 0) {
                while ($item = mysqli_fetch_assoc($items_result)) {
                    // Add items to the cart (bill_items table)
                    $insert_cart_query = "INSERT INTO bill_items (bill_id, item_id, quantity, source, unit) 
                                          VALUES ('$bill_id', '{$item['item_id']}', '{$item['quantity']}', '{$item['source']}', '{$item['unit']}')";
                    mysqli_query($link, $insert_cart_query);
                }
            }

            // Update the pending order status to 'Closed' and set the bill_id
            $update_query = "UPDATE PendingOrders SET status = 'Closed', bill_id = '$bill_id' WHERE order_id = '$order_id'";
            if (mysqli_query($link, $update_query)) {
                // Redirect to the cart page with the new bill_id
                header("Location: ../posBackend/orderItem.php?bill_id=$bill_id");
                exit();
            } else {
                echo "<script>alert('Failed to close order.');</script>";
            }
        } else {
            echo "<script>alert('Failed to create bill.');</script>";
        }
    } elseif ($_GET['action'] === 'delete') {
        // Delete the pending order and associated items
        $delete_order_items_query = "DELETE FROM PendingOrderItems WHERE order_id = '$order_id'";
        if (mysqli_query($link, $delete_order_items_query)) {
            $delete_order_query = "DELETE FROM PendingOrders WHERE order_id = '$order_id'";
            if (mysqli_query($link, $delete_order_query)) {
                // No confirmation message here, just delete
            } else {
                echo "<script>alert('Failed to delete order.');</script>";
            }
        } else {
            echo "<script>alert('Failed to delete order items.');</script>";
        }
    }
}

// Fetch all pending orders
$query = "SELECT * FROM PendingOrders ORDER BY order_id DESC";
$result = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/pos.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Pending Orders | Tables</title>
    <style>
        .wrapper { width: 1300px; padding-left: 200px; padding-top: 20px; }
        .table thead th { background-color: #343a40; color: white; }
        .table tbody tr:hover { background-color: #f8f9fa; }
        .btn-outline-dark { border-color: #343a40; color: #343a40; }
        .btn-outline-dark:hover { background-color: #343a40; color: white; }
        .btn-outline-success { border-color: #28a745; color: #28a745; }
        .btn-outline-success:hover { background-color: #28a745; color: white; }
        .btn-outline-danger { border-color: #dc3545; color: #dc3545; }
        .btn-outline-danger:hover { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid pt-5 pl-600">
            <div class="row">
                <div class="m-50">
                    <!-- Header and Buttons -->
                    <div class="mt-5 mb-3 d-flex justify-content-between align-items-center">
                        <h2 class="m-0">Pending Orders | Tables</h2>
                        <div>
                            <a href="javascript:void(0);" onclick="addPendingOrder()" class="btn btn-outline-dark"><i class="fa fa-plus"></i> Add Orders</a>
                            <a href="javascript:void(0);" onclick="window.print()" class="btn btn-outline-success"><i class="fa fa-print"></i> Print Orders</a>
                        </div>
                    </div>

                    <!-- Search Form -->
                    <div class="mb-3">
                        <form method="POST" action="#">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Search by Customer Name or Order ID">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-dark">Search</button>
                                </div>
                                <div class="col" style="text-align: right;">
                                    <a href="pendingOrders.php" class="btn btn-light">Show All</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Pending Orders Table -->
                    <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Order ID</th>";
                        echo "<th>Customer Name</th>";
                        echo "<th>Order Date</th>";
                        echo "<th>Action</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['order_id'] . "</td>";
                            echo "<td>" . $row['customer_name'] . "</td>";
                            echo "<td>" . $row['order_date'] . "</td>";
                            echo "<td>";
                            echo '<a href="../pendingOrderCrud/viewPendingOrder.php?order_id=' . $row['order_id'] . '" class="btn btn-outline-dark btn-sm"><i class="fa fa-eye"></i> View</a> ';
                            echo '<a href="#" onclick="confirmDelete(' . $row['order_id'] . ')" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>';
                            echo "</td>";
                            echo "</tr>";
                        }

                        echo "</tbody>";
                        echo "</table>";
                    } else {
                        echo '<div class="alert alert-danger"><em>No pending orders found.</em></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Pending Order -->
    <div class="modal fade" id="addPendingOrderModal" tabindex="-1" role="dialog" aria-labelledby="addPendingOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPendingOrderModalLabel">Add Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addPendingOrderForm" method="POST" action="../pendingOrderCrud/addPendingOrder.php">
                        <div class="form-group">
                            <label for="customer_name">Customer | Table Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include '../inc/dashFooter.php'; ?>

    <script>
    function addPendingOrder() {
        $('#addPendingOrderModal').modal('show');
    }

    function confirmDelete(order_id) {
        if (confirm("Are you sure you want to delete this order?")) {
            window.location.href = "../panel/pendingOrders.php?action=delete&order_id=" + order_id;
        }
    }
    </script>
</body>
</html>