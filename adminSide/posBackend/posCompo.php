<?php
session_start(); // Ensure session is started
require_once '../config.php';
include '../inc/dashHeader.php'; 

$bill_id = $_GET['bill_id'];
$staff_id = $_GET['staff_id'];
$member_id = $_GET['member_id'];
$reservation_id = $_GET['reservation_id'];

// Fetch all staff members (no WHERE clause)
$staff_query = "SELECT staff_id, staff_name, role FROM staffs"; // Removed the WHERE clause
$staff_result = mysqli_query($link, $staff_query);

if (!$staff_result) {
    die("Error fetching staff members: " . mysqli_error($link)); // Debugging: Output the error
}
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
                    <h3 class="card-title">Compo Payment</h3>
                </div>
                <div class="card-body">
                    <h5>Bill ID: <?php echo $bill_id; ?></h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item ID</th>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query to fetch cart items for the given bill_id from both bill_items and PendingOrderItems
                                $cart_query = "
                                    SELECT bi.item_id, 
                                           COALESCE(m.item_name, s.ItemName) AS item_name, 
                                           bi.quantity, 
                                           bi.source, 
                                           bi.unit
                                    FROM bill_items bi
                                    LEFT JOIN menu m ON bi.item_id = m.item_id AND bi.source = 'menu'
                                    LEFT JOIN stock s ON bi.item_id = s.ItemID AND bi.source = 'stock'
                                    WHERE bi.bill_id = '$bill_id'
                                    UNION
                                    SELECT poi.item_id, 
                                           COALESCE(m.item_name, s.ItemName) AS item_name, 
                                           poi.quantity, 
                                           poi.source, 
                                           poi.unit
                                    FROM pendingorderitems poi
                                    LEFT JOIN menu m ON poi.item_id = m.item_id AND poi.source = 'menu'
                                    LEFT JOIN stock s ON poi.item_id = s.ItemID AND poi.source = 'stock'
                                    WHERE poi.order_id = (SELECT order_id FROM pendingorders WHERE bill_id = '$bill_id')
                                ";
                                $cart_result = mysqli_query($link, $cart_query);

                                if ($cart_result && mysqli_num_rows($cart_result) > 0) {
                                    while ($cart_row = mysqli_fetch_assoc($cart_result)) {
                                        $item_id = $cart_row['item_id'];
                                        $item_name = $cart_row['item_name'];
                                        $quantity = $cart_row['quantity'];
                                        echo '<tr>';
                                        echo '<td>' . $item_id . '</td>';
                                        echo '<td>' . $item_name . '</td>';
                                        echo '<td>' . $quantity . '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="3">No Items in Cart.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Staff Selection Form for Compo Authorization -->
                    <div class="text-center mt-4">
                        <form id="compoForm" method="post">
                            <div class="form-group">
                                <label for="staff">Select Authorizing Staff:</label>
                                <select class="form-control" id="staff" name="staff" required>
                                    <option value="">-- Select Staff --</option>
                                    <?php while ($staff = mysqli_fetch_assoc($staff_result)): ?>
                                        <option value="<?= $staff['staff_id'] ?>"><?= $staff['staff_name'] ?> (<?= $staff['role'] ?>)</option>
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
    $authorizing_staff_id = $_POST['staff'];
    $currentTime = date('Y-m-d H:i:s');

    // Update the bill with compo payment information
    $updateQuery = "UPDATE bills SET payment_method = 'compo', payment_time = '$currentTime',
                    staff_id = $staff_id, member_id = $member_id, reservation_id = $reservation_id,
                    authorizing_staff_id = $authorizing_staff_id WHERE bill_id = $bill_id;";

    if ($link->query($updateQuery) === TRUE) {
        // Log the compo payment (optional)
        $logQuery = "INSERT INTO compologs (bill_id, authorizing_staff_id, compo_time)
                     VALUES ('$bill_id', '$authorizing_staff_id', '$currentTime');";
        $link->query($logQuery);

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