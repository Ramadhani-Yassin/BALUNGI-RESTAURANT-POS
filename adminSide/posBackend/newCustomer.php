<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Seating</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5 text-center">
    <?php
    require_once '../config.php';

    if (isset($_GET['new_customer']) && $_GET['new_customer'] === 'true') {
        // Check if table_id is provided, otherwise set it to NULL or a default value (e.g., '0000')
        $table_id = isset($_GET['table_id']) ? $_GET['table_id'] : null; // Optional table_id

        $bill_time = date('Y-m-d H:i:s');

        // Insert into Bills table with optional table_id
        if ($table_id !== null) {
            $insertQuery = "INSERT INTO Bills (table_id, bill_time) VALUES ('$table_id', '$bill_time')";
        } else {
            $insertQuery = "INSERT INTO Bills (bill_time) VALUES ('$bill_time')"; // No table_id
        }

        if ($link->query($insertQuery) === TRUE) {
            $bill_id = $link->insert_id; // Get the newly created bill_id

            // Redirect to orderItem.php with the bill_id and optional table_id
            if ($table_id !== null) {
                header("Location: orderItem.php?bill_id=$bill_id&table_id=$table_id");
            } else {
                header("Location: orderItem.php?bill_id=$bill_id"); // No table_id
            }
            exit(); // Ensure no further code is executed after the redirect
        } else {
            echo "<div class='alert alert-danger'>Error inserting data into Bills table: " . $link->error . "</div>";
        }
    }
    ?>
</div>

<!-- Add Bootstrap JS and dependencies -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>