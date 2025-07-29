<?php
session_start(); // Ensure session is started
?>
<!DOCTYPE html>
<html>
<head>
    <title>Check Staff Member Reservation Validity</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Check Staff Member Reservation Validity</h2>
        <form action="" method="post">
            <div class="form-group">
                <?php
                    $currentStaffId = $_SESSION['logged_account_id'] ?? "Please Login"; 
                ?>
                <label for="staffId">Staff ID:</label>
                <input type="text" id="staffId" name="staffId" class="form-control" 
                       value="<?= $currentStaffId ?>" readonly required>
            </div>
            <!-- Remove the memberId input field from the foreground -->
            <!-- Remove the reservationId input field from the foreground -->
            <div class="form-group">
                <button type="submit" class="btn btn-dark">Check Validity</button>
                <a class="btn btn-danger" href="javascript:window.history.back();">Cancel</a>
                <a class="btn btn-link" href="posTable.php">Tables Page</a>
            </div>
        </form>
    </div>

<div class="container mt-3">
    <?php
    // Include your database connection configuration
    require_once('../config.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $staffId = $_POST['staffId'];
        
        // Default values for memberId and reservationId
        $memberId = 1; // Default Member ID
        $reservationId = 1120251; // Default Reservation ID
        $bill_id = $_GET['bill_id'];

        // Check if the staff ID exists in the database
        $query = "SELECT * FROM staffs WHERE staff_id = '$staffId'";
        $result = mysqli_query($link, $query);

        if (!$result) {
            echo "Error: " . mysqli_error($link);
        } else {
            $staffExists = mysqli_num_rows($result) > 0;

            // Since we're setting default values, member and reservation existence checks are bypassed
            $memberExists = true; // Default member ID is assumed valid
            $reservationExists = true; // Default reservation ID is assumed valid

            if ($staffExists && $memberExists && $reservationExists) {
                echo '<div class="alert alert-success" role="alert">';
                echo "Staff, member, and reservation are valid.";
                echo '</div>';
                echo '<div class="mt-3">';
                // Use default values for memberId and reservationId in URLs
                echo '<a href="posCashPayment.php?bill_id=' . $bill_id . '&staff_id=' . $staffId . '&member_id=' . $memberId . '&reservation_id=' . $reservationId . '" class="btn btn-success">Cash</a>';
                echo '<a href="posCardPayment.php?bill_id=' . $bill_id . '&staff_id=' . $staffId . '&member_id=' . $memberId . '&reservation_id=' . $reservationId . '" class="btn btn-primary ml-2">Credit Card</a>';
                echo '</div>';
            } else {
                echo "Invalid staff, member, or reservation.";
            }
        }
    }
    ?>
</div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
