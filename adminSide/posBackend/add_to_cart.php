<?php
require_once '../config.php';

$bill_id = $_POST['bill_id'];
$item_id = $_POST['item_id'];
$source = $_POST['source']; // 'menu' or 'stock'
$unit = $_POST['unit'];     // 'base' or 'aggregate'
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1; // Default quantity is 1

if ($source === 'stock') {
    // Use prepared statements to prevent SQL injection
    $stock_query = "SELECT BaseUnitQuantity, ConversionRatio, AggregateQuantity, PendingAggregate FROM stock WHERE ItemID = ?";
    $stmt = mysqli_prepare($link, $stock_query);
    mysqli_stmt_bind_param($stmt, "s", $item_id);
    mysqli_stmt_execute($stmt);
    $stock_result = mysqli_stmt_get_result($stmt);
    
    if ($stock_result && mysqli_num_rows($stock_result) > 0) {
        $stock_row = mysqli_fetch_assoc($stock_result);
        $base_quantity = (int) $stock_row['BaseUnitQuantity'];  // m
        $conversion_ratio = (int) $stock_row['ConversionRatio']; // f
        $aggregate_quantity = (int) $stock_row['AggregateQuantity']; // a
        $pending_aggregate = (int) $stock_row['PendingAggregate']; // Leftover a that haven't converted to m

        // Validate quantity before processing
        if ($quantity <= 0) {
            echo '<script>alert("Invalid quantity!");</script>';
            exit();
        }

        // Start a transaction to ensure data consistency
        mysqli_begin_transaction($link);
        
        try {
            if ($unit === 'base') {
                if ($quantity > $base_quantity) {
                    echo '<script>alert("Not enough stock!");</script>';
                    exit();
                }
                $new_base_quantity = $base_quantity - $quantity;
                $new_aggregate_quantity = $aggregate_quantity - ($quantity * $conversion_ratio);
                $new_pending_aggregate = $pending_aggregate; // No change to pending aggregates
            } 
            elseif ($unit === 'aggregate') {
                if ($quantity > $aggregate_quantity) {
                    echo '<script>alert("Not enough stock!");</script>';
                    exit();
                }

                // Update aggregate quantity
                $new_aggregate_quantity = $aggregate_quantity - $quantity;

                // Accumulate pending aggregates
                $pending_aggregate += $quantity;

                // Check if we have enough to convert to base units
                $converted_base_units = intdiv($pending_aggregate, $conversion_ratio); // How many full base units can be converted
                $remaining_aggregates = $pending_aggregate % $conversion_ratio; // Leftovers for future transactions

                // Update values
                $new_base_quantity = max(0, $base_quantity - $converted_base_units);
                $new_pending_aggregate = $remaining_aggregates;
            } 
            else {
                echo '<script>alert("Invalid unit type!");</script>';
                exit();
            }

            // Update stock values using a prepared statement
                            $update_stock_query = "UPDATE stock SET BaseUnitQuantity = ?, PendingAggregate = ? WHERE ItemID = ?";
            $update_stmt = mysqli_prepare($link, $update_stock_query);
                          mysqli_stmt_bind_param($update_stmt, "iis", $new_base_quantity, $new_pending_aggregate, $item_id);
            mysqli_stmt_execute($update_stmt);
            
            // Commit the transaction if everything is successful
            mysqli_commit($link);
            echo '<script>alert("Stock updated successfully!");</script>';
        } 
        catch (Exception $e) {
            mysqli_rollback($link); // Rollback if an error occurs
            echo '<script>alert("Transaction failed!");</script>';
        }
    } 
    else {
        echo '<script>alert("Item not found in stock!");</script>';
        exit();
    }
}



// Check if the item already exists in the bill_items table
$existingItemQuery = "SELECT * FROM bill_items WHERE bill_id = $bill_id AND item_id = '$item_id'";
$existingItemResult = mysqli_query($link, $existingItemQuery);

if (mysqli_num_rows($existingItemResult) > 0) {
    // Item already exists; increase the quantity
    $updateQuantityQuery = "UPDATE bill_items SET quantity = quantity + $quantity WHERE bill_id = $bill_id AND item_id = '$item_id'";
    mysqli_query($link, $updateQuantityQuery);
} else {
    // Item doesn't exist; create a new bill item
    $insertItemQuery = "INSERT INTO bill_items (bill_id, item_id, quantity) VALUES ($bill_id, '$item_id', $quantity)";
    mysqli_query($link, $insertItemQuery);
}

// Close connection and redirect back to orderItem.php
mysqli_close($link);
header("Location: orderItem.php?bill_id=" . urlencode($bill_id));
exit();
?>
