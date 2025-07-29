<?php
session_start(); // Ensure session is started
require_once '../config.php';
include '../inc/dashHeader.php';

// Check if bill_id is passed via GET, otherwise use the session
if (isset($_GET['bill_id'])) {
    $bill_id = $_GET['bill_id'];
    $_SESSION['current_bill_id'] = $bill_id; // Store bill_id in session
} else if (isset($_SESSION['current_bill_id'])) {
    $bill_id = $_SESSION['current_bill_id']; // Use bill_id from session
} else {
    // If no bill_id is provided and no session exists, create a new bill
    $bill_id = createNewBillRecord(null); // Pass null for table_id
    $_SESSION['current_bill_id'] = $bill_id; // Store the new bill_id in session
}

$table_id = isset($_GET['table_id']) ? $_GET['table_id'] : null; // Table ID is optional

function createNewBillRecord($table_id) {
    global $link; // Assuming $link is your database connection
    
    $bill_time = date('Y-m-d H:i:s');
    
    $insert_query = "INSERT INTO bills (table_id, bill_time) VALUES (" . ($table_id !== null ? "'$table_id'" : "NULL") . ", '$bill_time')";

    if ($link->query($insert_query) === TRUE) {
        return $link->insert_id; // Return the newly inserted bill_id
    } else {
        return false;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/pos.css" />
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            margin-right: 20px;
            
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
        .cart-table {
        width: 100% !important; /* Force full width */
        max-width: 100% !important;
        margin: 0 auto;
        border-collapse: collapse;
    }
    
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Left Half: Search and Add Items -->
            <div class="col-md-6 half-section">
                <h2>Food & Drinks</h2>
                <div class="mb-3">
                    <form method="POST" action="#">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" required="" id="search" name="search" class="form-control" placeholder="Search Food & Drinks">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-dark">Search</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="showAllButton" class="btn btn-light" onclick="toggleShowAll()">Show All</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Display search results -->
                <div class="scrollable-table">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Item Name</th>
                                <th>Price</th>
                                <th>Add</th>
                            </tr>
                        </thead>
                        <tbody id="searchResults">
                            <?php
                            $show_all = isset($_GET['show_all']) ? $_GET['show_all'] : "false";
                            $result = null; // Default: No query executed

                            if ($show_all === "true") {
                                // Show all menu and stock items when "Show All" is clicked
                                $query = "SELECT item_id, item_name, item_price, 'menu' AS source, NULL AS unit FROM menu 
                                          UNION 
                                          SELECT ItemID AS item_id, CONCAT(ItemName, ' (', BaseUnitName, ')') AS item_name, PricePerBaseUnit AS item_price, 'stock' AS source, 'base' AS unit FROM stock 
                                          UNION 
                                          SELECT ItemID AS item_id, CONCAT(ItemName, ' (', AggregateUnitName, ')') AS item_name, PricePerSubUnit AS item_price, 'stock' AS source, 'aggregate' AS unit FROM stock WHERE ConversionRatio > 1 
                                          ORDER BY item_id;";
                                $result = mysqli_query($link, $query);
                            } elseif (isset($_POST['search']) && !empty($_POST['search'])) {
                                // Perform search when a keyword is typed
                                $search = $_POST['search'];

                                $query = "SELECT item_id, item_name, item_price, 'menu' AS source, NULL AS unit FROM menu 
                                          WHERE item_type LIKE '%$search%' 
                                          OR item_category LIKE '%$search%' 
                                          OR item_name LIKE '%$search%' 
                                          OR item_id LIKE '%$search%' 
                                          UNION 
                                          SELECT ItemID AS item_id, CONCAT(ItemName, ' (', BaseUnitName, ')') AS item_name, PricePerBaseUnit AS item_price, 'stock' AS source, 'base' AS unit FROM stock 
                                          WHERE ItemName LIKE '%$search%' 
                                          UNION 
                                          SELECT ItemID AS item_id, CONCAT(ItemName, ' (', AggregateUnitName, ')') AS item_name, PricePerSubUnit AS item_price, 'stock' AS source, 'aggregate' AS unit FROM stock 
                                          WHERE ItemName LIKE '%$search%' AND ConversionRatio > 1 
                                          ORDER BY item_id;";
                                $result = mysqli_query($link, $query);
                            }

                            if ($result) {
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['item_id'] . "</td>";
                                        echo "<td>" . $row['item_name'] . "</td>";
                                        echo "<td>" . number_format($row['item_price'], 2) . "</td>";

                                        // Check if the bill has been paid
                                        $payment_time_query = "SELECT payment_time FROM bills WHERE bill_id = '$bill_id'";
                                        $payment_time_result = mysqli_query($link, $payment_time_query);
                                        $has_payment_time = false;

                                        if ($payment_time_result && mysqli_num_rows($payment_time_result) > 0) {
                                            $payment_time_row = mysqli_fetch_assoc($payment_time_result);
                                            if (!empty($payment_time_row['payment_time'])) {
                                                $has_payment_time = true;
                                            }
                                        }

                                        // Display the "Add to Cart" button if the bill hasn't been paid
                                        if (!$has_payment_time) {
                                            echo '<td><form method="get" action="addItem.php">'
                                                . ($table_id ? '<input type="text" hidden name="table_id" value="' . $table_id . '">' : '')
                                                . '<input type="text" name="item_id" value=' . $row['item_id'] . ' hidden>'
                                                . '<input type="text" name="source" value=' . $row['source'] . ' hidden>'
                                                . '<input type="text" name="unit" value=' . ($row['unit'] ?? 'base') . ' hidden>'
                                                . '<input type="number" name="bill_id" value=' . $bill_id . ' hidden>'
                                                . '<input type="number" name="quantity" style="width:120px" placeholder="1 to 1000" required min="1" max="1000">'
                                                . '<input type="hidden" name="addToCart" value="1">'
                                                . '<button type="submit" class="btn btn-primary">Add to Cart</button>';
                                            echo "</form></td>";
                                        } else {
                                            echo '<td>Bill Paid</td>';
                                        }

                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No items found.</td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>Use search to find items.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Half: Display Cart Items -->
            <div class="col-md-5 half-section">
                <h2>Cart</h2>
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
                            // Query to fetch cart items for the given bill_id
                            $cart_query = "SELECT bi.*, 
                                                  COALESCE(m.item_name, s.ItemName) AS item_name, 
                                                  COALESCE(m.item_price, 
                                                           CASE WHEN bi.unit = 'base' THEN s.PricePerBaseUnit ELSE s.PricePerSubUnit END) AS item_price
                                           FROM bill_items bi
                                           LEFT JOIN menu m ON bi.item_id = m.item_id AND bi.source = 'menu'
                                           LEFT JOIN stock s ON bi.item_id = s.ItemID AND bi.source = 'stock'
                                           WHERE bi.bill_id = '$bill_id'";
                            $cart_result = mysqli_query($link, $cart_query);

                            if ($cart_result && mysqli_num_rows($cart_result) > 0) {
                                while ($cart_row = mysqli_fetch_assoc($cart_result)) {
                                    $item_id = $cart_row['item_id'];
                                    $item_name = $cart_row['item_name'];
                                    $item_price = $cart_row['item_price'];
                                    $quantity = $cart_row['quantity'];
                                    $total = $item_price * $quantity;
                                    $bill_item_id = $cart_row['bill_item_id'];
                                    $cart_total += $total;
                                    echo '<tr>';
                                    echo '<td>' . $item_id . '</td>';
                                    echo '<td>' . $item_name . ' <span class="unit-badge">' . ($cart_row['unit'] ?? 'base') . '</span></td>';
                                    echo '<td>' . number_format($item_price, 2) . '</td>';
                                    echo '<td>' . $quantity . '</td>';
                                    echo '<td>' . number_format($total, 2) . '</td>';

                                    // Check if the bill has been paid
                                    $payment_time_query = "SELECT payment_time FROM bills WHERE bill_id = '$bill_id'";
                                    $payment_time_result = mysqli_query($link, $payment_time_query);
                                    $has_payment_time = false;

                                    if ($payment_time_result && mysqli_num_rows($payment_time_result) > 0) {
                                        $payment_time_row = mysqli_fetch_assoc($payment_time_result);
                                        if (!empty($payment_time_row['payment_time'])) {
                                            $has_payment_time = true;
                                        }
                                    }

                                    // Display the "Delete" button if the bill hasn't been paid
                                    if (!$has_payment_time) {
                                        echo '<td><a class="btn btn-danger" href="deleteItem.php?bill_id=' . $bill_id . '&bill_item_id=' . $bill_item_id . '&table_id=' . $table_id . '&item_id=' . $item_id . '">Delete</a></td>';
                                    } else {
                                        echo '<td>Bill Paid</td>';
                                    }
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6">No Items in Cart.</td></tr>';
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

                <?php
                // Check if the payment time record exists for the bill
                $payment_time_query = "SELECT payment_time FROM bills WHERE bill_id = '$bill_id'";
                $payment_time_result = mysqli_query($link, $payment_time_query);
                $has_payment_time = false;

                if ($payment_time_result && mysqli_num_rows($payment_time_result) > 0) {
                    $payment_time_row = mysqli_fetch_assoc($payment_time_result);
                    if (!empty($payment_time_row['payment_time'])) {
                        $has_payment_time = true;
                    }
                }

                // If payment time record exists, show the "Print Receipt" button
                if ($has_payment_time) {
                    unset($_SESSION['current_bill_id']); // Clear the session after payment
                    echo '<div>';
                    echo '<a href="receipt.php?bill_id=' . $bill_id . '" class="btn btn-light">Print Receipt <span class="fa fa-receipt text-black"></span></a></div>';
                } elseif ($cart_total > 0) {
                    // Display the "Pay Bill" button
                    echo '<button type="button" class="btn btn-success" id="payBillButton" onclick="payBill()">Pay Bill</button>';
                } else {
                    echo '<h3>Add Item To Cart to Proceed</h3>';
                }
                ?>

                <!-- Payment Options Section -->
                <div id="paymentOptionsSection" style="display: none; margin-top: 20px;">
                    <div class="mt-3">
                        <a href="posCashPayment.php?bill_id=<?= $bill_id ?>&staff_id=<?= $_SESSION['logged_account_id'] ?? 1 ?>&member_id=1&reservation_id=1120251" class="btn btn-success">Cash</a>
                        <a href="posCardPayment.php?bill_id=<?= $bill_id ?>&staff_id=<?= $_SESSION['logged_account_id'] ?? 1 ?>&member_id=1&reservation_id=1120251" class="btn btn-primary ml-2">Card | Mobile</a>
                        <a href="posCreditors.php?bill_id=<?= $bill_id ?>&staff_id=<?= $_SESSION['logged_account_id'] ?? 1 ?>&member_id=1&reservation_id=1120251" class="btn btn-creditors">Creditors</a>
                        <a href="posCompo.php?bill_id=<?= $bill_id ?>&staff_id=<?= $_SESSION['logged_account_id'] ?? 1 ?>&member_id=1&reservation_id=1120251" class="btn btn-compo ml-2">Compo</a>
                    </div>
                </div>

                <form class="mt-3" action="newCustomer.php" method="get">
                    <input type="hidden" name="bill_id" value="<?= $bill_id ?>">
                    <button type="submit" name="new_customer" value="true" class="btn btn-warning">New Customer</button>
                </form>
            </div>
        </div>
    </div>

    <?php include '../inc/dashFooter.php'; ?>

    <script>
    function toggleShowAll() {
        let currentUrl = new URL(window.location.href);
        let showAll = currentUrl.searchParams.get("show_all");

        if (showAll === "true") {
            // Hide items (remove 'show_all' from URL)
            currentUrl.searchParams.set("show_all", "false");
        } else {
            // Show all items
            currentUrl.searchParams.set("show_all", "true");
        }

        // Redirect with updated URL
        window.location.href = currentUrl.toString();
    }

    function payBill() {
        // Hide the "Pay Bill" button
        document.getElementById('payBillButton').style.display = 'none';

        // Show the payment options section
        document.getElementById('paymentOptionsSection').style.display = 'block';
    }

    // Live search functionality
    $(document).ready(function() {
        $('#search').on('input', function() {
            var searchTerm = $(this).val();
            
            if (searchTerm.length >= 1) { // Only search if at least 1 character is entered
                $.ajax({
                    url: 'liveSearch.php',
                    type: 'POST',
                    data: { search: searchTerm, bill_id: '<?= $bill_id ?>' },
                    success: function(response) {
                        $('#searchResults').html(response);
                    }
                });
            } else if (searchTerm.length === 0) {
                // Clear results if search term is empty
                $('#searchResults').html('<tr><td colspan="4">Use search to find items.</td></tr>');
            }
        });
    });
    </script>
</body>
</html>