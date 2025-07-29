<?php
session_start();
require_once '../config.php';
include '../inc/dashHeader.php';

if (!isset($_GET['order_id'])) {
    die("Order ID is required.");
}

$order_id = $_GET['order_id'];

// Fetch pending order details
$order_query = "SELECT * FROM pendingorders WHERE order_id = '$order_id'";
$order_result = mysqli_query($link, $order_query);
$order = mysqli_fetch_assoc($order_result);

// Fetch items in the pending order
$items_query = "SELECT * FROM pendingorderitems WHERE order_id = '$order_id'";
$items_result = mysqli_query($link, $items_query);

// Fetch items from Menu and Stock for the search functionality
$search_query = "SELECT item_id, item_name, item_price, 'menu' AS source, NULL AS unit 
                 FROM menu 
                 UNION 
                 SELECT ItemID AS item_id, CONCAT(ItemName, ' (', BaseUnitName, ')') AS item_name, 
                        PricePerBaseUnit AS item_price, 'stock' AS source, 'base' AS unit 
                 FROM stock 
                 UNION 
                 SELECT ItemID AS item_id, CONCAT(ItemName, ' (', AggregateUnitName, ')') AS item_name, 
                        PricePerSubUnit AS item_price, 'stock' AS source, 'aggregate' AS unit 
                 FROM stock 
                 WHERE ConversionRatio > 1";

// Check if a search term is submitted
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $search_query = "SELECT item_id, item_name, item_price, 'menu' AS source, NULL AS unit 
                     FROM menu 
                     WHERE item_name LIKE '%$search%' 
                     OR item_id LIKE '%$search%' 
                     UNION 
                     SELECT ItemID AS item_id, CONCAT(ItemName, ' (', BaseUnitName, ')') AS item_name, 
                            PricePerBaseUnit AS item_price, 'stock' AS source, 'base' AS unit 
                     FROM stock 
                     WHERE ItemName LIKE '%$search%' 
                     UNION 
                     SELECT ItemID AS item_id, CONCAT(ItemName, ' (', AggregateUnitName, ')') AS item_name, 
                            PricePerSubUnit AS item_price, 'stock' AS source, 'aggregate' AS unit 
                     FROM stock 
                     WHERE ItemName LIKE '%$search%' AND ConversionRatio > 1";
}

// Check if "Show All" is clicked
$show_all = isset($_GET['show_all']) ? $_GET['show_all'] : "false";
if ($show_all === "true") {
    // Show all items
    $search_query = "SELECT item_id, item_name, item_price, 'menu' AS source, NULL AS unit 
                     FROM menu 
                     UNION 
                     SELECT ItemID AS item_id, CONCAT(ItemName, ' (', BaseUnitName, ')') AS item_name, 
                            PricePerBaseUnit AS item_price, 'stock' AS source, 'base' AS unit 
                     FROM stock 
                     UNION 
                     SELECT ItemID AS item_id, CONCAT(ItemName, ' (', AggregateUnitName, ')') AS item_name, 
                            PricePerSubUnit AS item_price, 'stock' AS source, 'aggregate' AS unit 
                     FROM stock 
                     WHERE ConversionRatio > 1";
}

$search_result = mysqli_query($link, $search_query);

// Check if the bill has been paid
$bill_id = $order['bill_id'];
$payment_time_query = "SELECT payment_time FROM bills WHERE bill_id = '$bill_id'";
$payment_time_result = mysqli_query($link, $payment_time_query);
$has_payment_time = false;

if ($payment_time_result && mysqli_num_rows($payment_time_result) > 0) {
    $payment_time_row = mysqli_fetch_assoc($payment_time_result);
    if (!empty($payment_time_row['payment_time'])) {
        $has_payment_time = true;
    }
}

// Handle "Pay Bill" action
if (isset($_POST['pay_bill'])) {
    // Fetch all items in the pending order
    $items_query = "SELECT * FROM pendingorderitems WHERE order_id = '$order_id'";
    $items_result = mysqli_query($link, $items_query);

    if ($items_result && mysqli_num_rows($items_result) > 0) {
        while ($item = mysqli_fetch_assoc($items_result)) {
            $item_id = $item['item_id'];
            $item_name = $item['item_name'];
            $quantity = $item['quantity'];
            $item_price = $item['item_price'];
            $source = $item['source'];
            $unit = isset($item['unit']) ? $item['unit'] : 'base';

            // Insert the item into the bill_items table with correct unit
            $insert_query = "INSERT INTO bill_items (bill_id, item_id, item_name, quantity, source, unit, item_price) 
                             VALUES ('$bill_id', '$item_id', '$item_name', '$quantity', '$source', '$unit', '$item_price')";
            mysqli_query($link, $insert_query);
        }

        // Mark the pending order as completed
        $update_query = "UPDATE pendingorders SET status = 'Completed' WHERE order_id = '$order_id'";
        mysqli_query($link, $update_query);

        // Redirect to the payment page
        header("Location: viewPendingOrder.php?order_id=$order_id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/pos.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>View Pending Order</title>
    <style>
        .scrollable-table {
            max-height: 400px;
            overflow-y: auto;
            display: block;
        }
        .scrollable-table table {
            width: 100%;
            table-layout: fixed;
        }
        .scrollable-table th,
        .scrollable-table td {
            width: auto;
            text-align: left;
            padding: 8px;
        }
        .scrollable-table th {
            background-color: white;
            color: black;
            font-weight: bold;
        }
        .scrollable-table tbody tr:hover {
            background-color: #f8f9fa;
        }
        .container-fluid {
            padding-top: 60px;
            padding-left: 200px;
            padding-right: 20px;
        }
        .half-section {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
           
        }
        #paymentOptionsSection a {
            margin-right: 20px;
        }
        .btn-creditors {
            background-color: #cd29be;
            color: white;
            border: none;
        }
        .btn-creditors:hover, .btn-pink:focus {
            background-color: #cd29be;
            color: white;
        }
        .btn-compo {
            background-color: #873e23;
            color: white;
            border: none;
        }
        .btn-compo:hover, .btn-orange:focus {
            background-color: #873e23;
            color: white;
        }
        .unit-badge {
            font-size: 0.8em;
            padding: 2px 5px;
            border-radius: 3px;
            background-color: #f0f0f0;
            color: #333;
        }
        
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Left Half: Search and Add Items -->
            <div class="col-md-6 half-section">
                <h2><?= $order['customer_name'] ?>'s Order</h2>
                <div class="mb-3">
                    <form id="searchForm" method="GET" action="viewPendingOrder.php">
                        <input type="hidden" name="order_id" value="<?= $order_id ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" id="searchInput" name="search" class="form-control" placeholder="Search Food & Drinks" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-dark">Search</button>
                            </div>
                            <div class="col-md-3">
                                <!--<button type="button" id="showAllButton" class="btn btn-light">Show All</button>-->
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Display search results -->
                <div id="searchResults" class="scrollable-table">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Item Name</th>
                                <th>Price</th>
                                <th>Add</th>
                            </tr>
                        </thead>
                        <tbody id="searchResultsBody">
                            <?php
                            if ($search_result && mysqli_num_rows($search_result) > 0) {
                                while ($row = mysqli_fetch_assoc($search_result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['item_id'] . "</td>";
                                    echo "<td>" . $row['item_name'] . "</td>";
                                    echo "<td>" . number_format($row['item_price'], 2) . "</td>";
                                    echo "<td>";
                                    if (!$has_payment_time) {
                                        echo "<form method='POST' action='../pendingOrderCrud/addPendingItem.php' style='display:inline;'>
                                                <input type='hidden' name='order_id' value='$order_id'>
                                                <input type='hidden' name='item_id' value='{$row['item_id']}'>
                                                <input type='hidden' name='source' value='{$row['source']}'>
                                                <input type='hidden' name='unit' value='" . ($row['unit'] ?? 'base') . "'>
                                                <input type='number' name='quantity' placeholder='1 to 1000' required min='1' max='1000' style='width: 100px;'>
                                                <button type='submit' class='btn btn-primary'>Add</button>
                                              </form>";
                                    } else {
                                        echo "Bill Paid";
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No items found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Half: Display Pending Order Items -->
            <div class="col-md-6 half-section">
                <br><br><br>
                <h2>Items Added For <?= $order['customer_name'] ?></h2>
                <div class="scrollable-table">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Item ID</th>
                                <th>Item Name</th>
                                <th>Price (TZS)</th>
                                <th>Quantity</th>
                                <th>Total (TZS)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cart_total = 0;
                            if ($items_result && mysqli_num_rows($items_result) > 0) {
                                while ($item = mysqli_fetch_assoc($items_result)) {
                                    $total = $item['item_price'] * $item['quantity'];
                                    $cart_total += $total;
                                    echo "<tr>";
                                    echo "<td>" . $item['item_id'] . "</td>";
                                    echo "<td>" . $item['item_name'] . " <span class='unit-badge'>" . ($item['unit'] ?? 'base') . "</span></td>";
                                    echo "<td>" . number_format($item['item_price'], 2) . "</td>";
                                    echo "<td>" . $item['quantity'] . "</td>";
                                    echo "<td>" . number_format($total, 2) . "</td>";
                                    echo "<td>";
                                    if (!$has_payment_time) {
                                        echo "<a href='../pendingOrderCrud/deletePendingItem.php?order_id=$order_id&item_id={$item['item_id']}&source={$item['source']}&unit={$item['unit']}' 
                                            class='btn btn-danger'>Delete</a>";
                                    } else {
                                        echo "Bill Paid";
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No items found in this pending order.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Display Cart Total and Grand Total -->
                <div style="margin-top: 20px;">
                    <table class="table table-bordered">
                        <tr>
                            <th>Cart Total</th>
                            <td>TZS <?= number_format($cart_total, 2) ?></td>
                        </tr>
                        <tr>
                            <th>Grand Total</th>
                            <td>TZS <?= number_format($cart_total, 2) ?></td>
                        </tr>
                    </table>
                </div>

                <!-- Pay Bill Button and Payment Options -->
                <?php if (!$has_payment_time && mysqli_num_rows($items_result) > 0): ?>
                    <div style="margin-top: 20px;">
                        <button type="button" class="btn btn-success" id="payBillButton" onclick="payBill()">Pay Bill</button>
                    </div>

                    <div id="paymentOptionsSection" style="display: none; margin-top: 20px;">
                        <div class="mt-3">
                            <a href="../posBackend/posCashPayment.php?bill_id=<?= $bill_id ?>&staff_id=<?= $_SESSION['logged_account_id'] ?? 1 ?>&member_id=1&reservation_id=1120251" class="btn btn-success">Cash</a>
                            <a href="../posBackend/posCardPayment.php?bill_id=<?= $bill_id ?>&staff_id=<?= $_SESSION['logged_account_id'] ?? 1 ?>&member_id=1&reservation_id=1120251" class="btn btn-primary ml-2">Card | Mobile</a>
                            <a href="../posBackend/posCreditors.php?bill_id=<?= $bill_id ?>&staff_id=<?= $_SESSION['logged_account_id'] ?? 1 ?>&member_id=1&reservation_id=1120251" class="btn btn-creditors">Creditors</a>
                            <a href="../posBackend/posCompo.php?bill_id=<?= $bill_id ?>&staff_id=<?= $_SESSION['logged_account_id'] ?? 1 ?>&member_id=1&reservation_id=1120251" class="btn btn-compo ml-2">Compo</a>
                        </div>
                    </div>
                <?php elseif ($has_payment_time): ?>
                    <div style="margin-top: 20px;">
                        <a href="receipt.php?bill_id=<?= $bill_id ?>" class="btn btn-light">Print Receipt <span class="fa fa-receipt text-black"></span></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include '../inc/dashFooter.php'; ?>

    <script>
    // Show all items when "Show All" is clicked
    document.getElementById('showAllButton')?.addEventListener('click', function () {
        const searchResults = document.getElementById('searchResults');
        searchResults.style.display = 'block';
        window.location.href = "viewPendingOrder.php?order_id=<?= $order_id ?>&show_all=true";
    });

    // Live search functionality
    document.getElementById('searchInput').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#searchResultsBody tr');

        rows.forEach(row => {
            const itemName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            if (itemName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Pay Bill functionality
    function payBill() {
        document.getElementById('payBillButton').style.display = 'none';
        document.getElementById('paymentOptionsSection').style.display = 'block';
    }
    </script>
</body>
</html>