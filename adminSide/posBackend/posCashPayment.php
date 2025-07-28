<?php
session_start(); // Ensure session is started
require_once '../config.php';
include '../inc/dashHeader.php'; 

$bill_id = $_GET['bill_id'];
$staff_id = $_GET['staff_id'];
$member_id = intval($_GET['member_id']);
$reservation_id = $_GET['reservation_id'];
?>

<!-- Add custom CSS for top margin and padding -->
<style>
    .top-spacer {
        margin-top: 12rem; /* Adjust this value to push content down */
        padding-top: 2rem; /* Add padding to ensure content is not too close to the top */
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Cash Payment</h3>
                </div>
                <div class="card-body">
                    <h5>Bill ID: <?php echo $bill_id; ?></h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item ID</th>
                                    <th>Item Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query to fetch cart items for the given bill_id from both bill_items and PendingOrderItems
                                $cart_query = "
                                    SELECT bi.item_id, 
                                           COALESCE(m.item_name, s.ItemName) AS item_name, 
                                           COALESCE(m.item_price, CASE WHEN bi.unit = 'base' THEN s.PricePerBaseUnit ELSE s.PricePerSubUnit END) AS item_price, 
                                           bi.quantity, 
                                           bi.source, 
                                           bi.unit
                                    FROM bill_items bi
                                    LEFT JOIN Menu m ON bi.item_id = m.item_id AND bi.source = 'menu'
                                    LEFT JOIN stock s ON bi.item_id = s.ItemID AND bi.source = 'stock'
                                    WHERE bi.bill_id = '$bill_id'
                                    UNION
                                    SELECT poi.item_id, 
                                           COALESCE(m.item_name, s.ItemName) AS item_name, 
                                           COALESCE(m.item_price, CASE WHEN poi.unit = 'base' THEN s.PricePerBaseUnit ELSE s.PricePerSubUnit END) AS item_price, 
                                           poi.quantity, 
                                           poi.source, 
                                           poi.unit
                                    FROM PendingOrderItems poi
                                    LEFT JOIN Menu m ON poi.item_id = m.item_id AND poi.source = 'menu'
                                    LEFT JOIN stock s ON poi.item_id = s.ItemID AND poi.source = 'stock'
                                    WHERE poi.order_id = (SELECT order_id FROM PendingOrders WHERE bill_id = '$bill_id')
                                ";
                                $cart_result = mysqli_query($link, $cart_query);
                                $cart_total = 0; // Cart total

                                if ($cart_result && mysqli_num_rows($cart_result) > 0) {
                                    while ($cart_row = mysqli_fetch_assoc($cart_result)) {
                                        $item_id = $cart_row['item_id'];
                                        $item_name = $cart_row['item_name'];
                                        $item_price = $cart_row['item_price'];
                                        $quantity = $cart_row['quantity'];
                                        $total = $item_price * $quantity;
                                        $cart_total += $total;
                                        echo '<tr>';
                                        echo '<td>' . $item_id . '</td>';
                                        echo '<td>' . $item_name . '</td>';
                                        echo '<td>TZS ' . number_format($item_price, 2) . '</td>';
                                        echo '<td>' . $quantity . '</td>';
                                        echo '<td>TZS ' . number_format($total, 2) . '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="6">No Items in Cart.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="text-right">
                        <?php 
                        echo "<strong>Total:</strong> TZS " . number_format($cart_total, 2) . "<br>";
                        $GRANDTOTAL = $cart_total;
                        echo "<strong>Grand Total:</strong> TZS " . number_format($GRANDTOTAL, 2);
                        ?>
                    </div>
                </div>
            </div>

            <!-- Cash Payment Section -->
            <div id="cash-payment" class="container-fluid mt-5 pt-5 pl-5 pr-5 mb-5">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <form action="" method="post">
                            <!-- Add hidden input fields for bill_id, staff_id, member_id, and reservation_id -->
                            <input type="hidden" name="bill_id" value="<?php echo $bill_id; ?>">
                            <input type="hidden" name="staff_id" value="<?php echo $staff_id; ?>">
                            <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
                            <input type="hidden" name="reservation_id" value="<?php echo $reservation_id; ?>">
                            <input type="hidden" name="GRANDTOTAL" value="<?php echo $GRANDTOTAL; ?>">

                            <!-- Pay Button -->
                            <button type="submit" name="pay" class="btn btn-dark mt-2">Print Receipt 🧾</button>
                        </form>
                    </div>
                </div>
            </div>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pay'])) {
                // Check if the bill has already been paid
                $billCheckQuery = "SELECT payment_time FROM Bills WHERE bill_id = $bill_id";
                $billCheckResult = $link->query($billCheckQuery);

                if ($billCheckResult) {
                    if ($billCheckResult->num_rows > 0) {
                        $billRow = $billCheckResult->fetch_assoc();
                        if ($billRow['payment_time'] !== null) {
                            exit;
                        }
                    }
                } else {
                    echo "Error checking bill: " . $link->error;
                    exit;
                }

                // Update the payment method, bill time, and other details
                $currentTime = date('Y-m-d H:i:s');
                $updateQuery = "UPDATE Bills SET payment_method = 'cash', payment_time = '$currentTime',
                                staff_id = $staff_id, member_id = $member_id, reservation_id = $reservation_id
                                WHERE bill_id = $bill_id;";

                $points = intval($GRANDTOTAL);
                if ($link->query($updateQuery) === TRUE) {
                    // Record the payment in payment_records table
                    $recordPaymentQuery = "INSERT INTO payment_records 
                                         (bill_id, payment_method, payment_amount, payment_time, staff_id, member_id, tax_amount)
                                         VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $link->prepare($recordPaymentQuery);
                    $payment_method = 'cash';
                    $tax_amount = 0;
                    $stmt->bind_param("isdsiid", $bill_id, $payment_method, $GRANDTOTAL, $currentTime, $staff_id, $member_id, $tax_amount);
                    $stmt->execute();

                    if (!empty($member_id)) {
                        $update_points_sql = "UPDATE Memberships SET points = points + $points WHERE member_id = $member_id;";
                        $link->query($update_points_sql);
                    }

                    // Redirect to receipt download
                    echo '<script>window.location.href = "receipt.php?bill_id=' . $bill_id . '&download=true";</script>';
                    exit;
                } else {
                    echo "Error updating bill: " . $link->error;
                }
            }
            ?>
        </div>
    </div>
</div>

<?php include '../inc/dashFooter.php'; ?>