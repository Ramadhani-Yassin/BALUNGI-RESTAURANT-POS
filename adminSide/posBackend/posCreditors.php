<?php
session_start(); // Ensure session is started
require_once '../config.php';
include '../inc/dashHeader.php'; 

$bill_id = $_GET['bill_id'];
$staff_id = $_GET['staff_id'];
$member_id = $_GET['member_id'];
$reservation_id = $_GET['reservation_id'];

// Fetch creditors from the database
$creditors_query = "SELECT ID, Name FROM Creditors";
$creditors_result = mysqli_query($link, $creditors_query);

?>

<style>
    .top-spacer {
        margin-top: 12rem;
        padding-top: 2rem;
    }
</style>

<div class="container-fluid top-spacer">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Creditors</h3>
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
                                $cart_total = 0;

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
                        $GRANDTOTAL = $cart_total; // No tax for creditors
                        echo "<strong>Grand Total:</strong> TZS " . number_format($GRANDTOTAL, 2);
                        ?>
                    </div>
                    <!-- Creditor Selection Form -->
                    <div class="text-center mt-4">
                        <form id="creditorForm" method="post">
                            <div class="form-group">
                                <label for="creditor">Select Creditor:</label>
                                <select class="form-control" id="creditor" name="creditor" required>
                                    <option value="">-- Select Creditor --</option>
                                    <?php while ($creditor = mysqli_fetch_assoc($creditors_result)): ?>
                                        <option value="<?= $creditor['ID'] ?>"><?= $creditor['Name'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div><br>
                            <button type="submit" name="pay_done" class="btn btn-dark">Print Receipt 🧾</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pay_done'])) {
    $creditor_id = $_POST['creditor'];
    $currentTime = date('Y-m-d H:i:s');

    // Update the bill with creditor information
    $updateQuery = "UPDATE Bills SET payment_method = 'creditor', payment_time = '$currentTime',
                    staff_id = $staff_id, member_id = $member_id, reservation_id = $reservation_id,
                    creditor_id = $creditor_id WHERE bill_id = $bill_id;";

    if ($link->query($updateQuery) === TRUE) {
        // Update the creditor's due amount
        $updateCreditorQuery = "UPDATE Creditors SET Due_Amount = Due_Amount + $GRANDTOTAL WHERE ID = $creditor_id;";
        $link->query($updateCreditorQuery);

        // JavaScript for automatic receipt download
        echo '<script>
                setTimeout(function() {
                    window.location.href = "receipt.php?bill_id=' . $bill_id . '";
                }, 1000);
              </script>';
    } else {
        echo "Error updating bill: " . $link->error;
    }
}
?>

<?php include '../inc/dashFooter.php'; ?>