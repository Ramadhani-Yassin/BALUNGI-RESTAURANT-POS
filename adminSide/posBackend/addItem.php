<?php
session_start();
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['addToCart'])) {
    // Retrieve form data
    $bill_id = $_GET['bill_id'];
    $item_id = $_GET['item_id'];
    $quantity = $_GET['quantity'];
    $source = $_GET['source']; // 'menu' or 'stock'
    $unit = isset($_GET['unit']) ? $_GET['unit'] : 'base'; // 'base' or 'aggregate'
    $table_id = isset($_GET['table_id']) ? $_GET['table_id'] : null;

    // Validate input
    if (empty($bill_id) || empty($item_id) || empty($quantity) || empty($source)) {
        die("All fields are required.");
    }

    // Fetch item details based on the source and unit type
    $item_name = '';
    $item_price = 0;
    $item_category = '';
    
    if ($source === 'menu') {
        $item_query = "SELECT item_name, item_price, item_category FROM Menu WHERE item_id = '$item_id'";
        $item_result = mysqli_query($link, $item_query);
        
        if (!$item_result || mysqli_num_rows($item_result) === 0) {
            die("Menu item not found.");
        }

        $item_row = mysqli_fetch_assoc($item_result);
        $item_name = $item_row['item_name'];
        $item_price = $item_row['item_price'];
        $item_category = $item_row['item_category'];
    } else {
        // For stock items, use prepared statements for security
        $item_query = $unit === 'base' 
            ? "SELECT ItemName, PricePerBaseUnit AS item_price FROM stock WHERE ItemID = ?"
            : "SELECT ItemName, PricePerSubUnit AS item_price FROM stock WHERE ItemID = ?";
        
        $stmt = mysqli_prepare($link, $item_query);
        mysqli_stmt_bind_param($stmt, "s", $item_id);
        mysqli_stmt_execute($stmt);
        $item_result = mysqli_stmt_get_result($stmt);
        
        if (!$item_result || mysqli_num_rows($item_result) === 0) {
            die("Stock item not found.");
        }

        $item_row = mysqli_fetch_assoc($item_result);
        $item_name = $item_row['ItemName'];
        $item_price = $item_row['item_price'];
        
        // Stock quantity management with prepared statements
        $stock_query = "SELECT BaseUnitQuantity, ConversionRatio, AggregateQuantity, PendingAggregate FROM stock WHERE ItemID = ?";
        $stmt = mysqli_prepare($link, $stock_query);
        mysqli_stmt_bind_param($stmt, "s", $item_id);
        mysqli_stmt_execute($stmt);
        $stock_result = mysqli_stmt_get_result($stmt);
        
        if ($stock_result && mysqli_num_rows($stock_result) > 0) {
            $stock_row = mysqli_fetch_assoc($stock_result);
            $base_quantity = (int)$stock_row['BaseUnitQuantity'];
            $conversion_ratio = (int)$stock_row['ConversionRatio'];
            $aggregate_quantity = (int)$stock_row['AggregateQuantity'];
            $pending_aggregate = (int)$stock_row['PendingAggregate'];

            // Validate quantity
            if ($quantity <= 0) {
                die("Invalid quantity.");
            }

            // Begin transaction for stock updates
            mysqli_begin_transaction($link);
            
            try {
                if ($unit === 'base') {
                    if ($quantity > $base_quantity) {
                        echo "<script>
                        alert('Not enough Items available on Balungi Stock ⚠️‼️.');
                        window.location.href = 'orderItem.php'; // Redirect to cart page instead of going back
                      </script>";
                        exit();
                    }
                    $new_base_quantity = $base_quantity - $quantity;
                    $new_aggregate_quantity = $aggregate_quantity - ($quantity * $conversion_ratio);
                    $new_pending_aggregate = $pending_aggregate;
                } 
                elseif ($unit === 'aggregate') {
                    if ($quantity > $aggregate_quantity) {
                        echo "<script>
                        alert('Not enough Items available on Balungi Stock ⚠️‼️.');
                        window.location.href = 'orderItem.php'; // Redirect to cart page instead of going back
                      </script>";
                        exit();
                    }

                    // Reduce aggregate quantity
                    $new_aggregate_quantity = $aggregate_quantity - $quantity;

                    // Add to pending aggregate buffer
                    $pending_aggregate += $quantity;

                    // Convert to base units if pending aggregates reach the threshold
                    $converted_units = intdiv($pending_aggregate, $conversion_ratio);
                    $remaining_pending = $pending_aggregate % $conversion_ratio;

                    // Reduce base units only when full conversion happens
                    $new_base_quantity = max(0, $base_quantity - $converted_units);
                    $new_pending_aggregate = $remaining_pending;
                } 
                else {
                    throw new Exception("Invalid unit type.");
                }

                // Update stock with prepared statement
                $update_stock_query = "UPDATE stock SET BaseUnitQuantity = ?, AggregateQuantity = ?, PendingAggregate = ? WHERE ItemID = ?";
                $update_stmt = mysqli_prepare($link, $update_stock_query);
                mysqli_stmt_bind_param($update_stmt, "iiis", $new_base_quantity, $new_aggregate_quantity, $new_pending_aggregate, $item_id);
                mysqli_stmt_execute($update_stmt);
                
                if (mysqli_stmt_affected_rows($update_stmt) === 0) {
                    throw new Exception("Failed to update stock.");
                }
                
                mysqli_commit($link);
            } 
            catch (Exception $e) {
                mysqli_rollback($link);
                die("Transaction failed: " . $e->getMessage());
            }
        }
    }

    // Insert the item into bill_items (without item_name since the column doesn't exist)
    $insert_query = "INSERT INTO bill_items 
                    (bill_id, item_id, quantity, source, unit) 
                    VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $insert_query);
    mysqli_stmt_bind_param($stmt, "isiss", $bill_id, $item_id, $quantity, $source, $unit);
    
    if (mysqli_stmt_execute($stmt)) {
        // For menu items in 'Main Dishes' category
        if ($source === 'menu' && isset($item_category) && strtolower($item_category) === 'main dishes') {
            $currentTime = date('Y-m-d H:i:s');
            $insert_kitchen_query = "INSERT INTO Kitchen (table_id, item_id, quantity, time_submitted) 
                                   VALUES (". ($table_id !== null ? "'$table_id'" : "NULL") .", '$item_id', '$quantity', '$currentTime')";
            if (!mysqli_query($link, $insert_kitchen_query)) {
                error_log("Error inserting into Kitchen: " . mysqli_error($link));
            }
        }

        header("Location: orderItem.php?bill_id=$bill_id" . ($table_id ? "&table_id=$table_id" : ""));
        exit();
    } else {
        die("Failed to add item: " . mysqli_error($link));
    }
} else {
    header("Location: orderItem.php");
    exit();
}