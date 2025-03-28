<?php
session_start();
require_once '../config.php';

if (!isset($_GET['order_id']) || !isset($_GET['item_id'])) {
    die("Order ID and Item ID are required.");
}

$order_id = $_GET['order_id'];
$item_id = $_GET['item_id'];

// Fetch item details before deletion using prepared statements
$fetch_query = "SELECT pending_order_item_id, quantity, source, unit FROM PendingOrderItems WHERE order_id = ? AND item_id = ?";
$stmt = mysqli_prepare($link, $fetch_query);
mysqli_stmt_bind_param($stmt, "ss", $order_id, $item_id);
mysqli_stmt_execute($stmt);
$fetch_result = mysqli_stmt_get_result($stmt);

if (!$fetch_result || mysqli_num_rows($fetch_result) === 0) {
    die("Item not found in the pending order.");
}

$item_row = mysqli_fetch_assoc($fetch_result);
$pending_order_item_id = $item_row['pending_order_item_id'];
$quantity = $item_row['quantity'];
$source = $item_row['source'];
$unit = $item_row['unit'] ?? 'base';

// Fetch item category if it's a menu item
$item_category = null;
if ($source === 'menu') {
    $category_query = "SELECT item_category FROM Menu WHERE item_id = ?";
    $stmt = mysqli_prepare($link, $category_query);
    mysqli_stmt_bind_param($stmt, "s", $item_id);
    mysqli_stmt_execute($stmt);
    $category_result = mysqli_stmt_get_result($stmt);

    if ($category_result && mysqli_num_rows($category_result) > 0) {
        $category_row = mysqli_fetch_assoc($category_result);
        $item_category = $category_row['item_category'];
    }
}

// Begin transaction for data consistency
mysqli_begin_transaction($link);

try {
    // Delete the specific item from PendingOrderItems using the primary key
    $delete_query = "DELETE FROM PendingOrderItems WHERE pending_order_item_id = ?";
    $stmt = mysqli_prepare($link, $delete_query);
    mysqli_stmt_bind_param($stmt, "i", $pending_order_item_id);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Failed to delete item from pending order: " . mysqli_error($link));
    }

    // Handle stock items - restore quantities
    if ($source === 'stock') {
        $stock_query = "SELECT BaseUnitQuantity, ConversionRatio, AggregateQuantity, PendingAggregate 
                       FROM stock WHERE ItemID = ?";
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

            if ($unit === 'base') {
                $new_base_quantity = $base_quantity + $quantity;
                $update_stock_query = "UPDATE stock SET BaseUnitQuantity = ? WHERE ItemID = ?";
                $stmt = mysqli_prepare($link, $update_stock_query);
                mysqli_stmt_bind_param($stmt, "is", $new_base_quantity, $item_id);
            } 
            elseif ($unit === 'aggregate') {
                // Handle pending aggregate restoration
                $new_pending_aggregate = $pending_aggregate - $quantity;
                if ($new_pending_aggregate < 0) $new_pending_aggregate = 0;
                
                $convert_to_base = floor($new_pending_aggregate / $conversion_ratio);
                $new_base_quantity = $base_quantity + $convert_to_base;
                $new_aggregate_quantity = $aggregate_quantity + $quantity - ($convert_to_base * $conversion_ratio);
                
                $update_stock_query = "UPDATE stock SET 
                                     BaseUnitQuantity = ?, 
                                     AggregateQuantity = ?, 
                                     PendingAggregate = ? 
                                     WHERE ItemID = ?";
                $stmt = mysqli_prepare($link, $update_stock_query);
                mysqli_stmt_bind_param($stmt, "iiis", $new_base_quantity, $new_aggregate_quantity, $new_pending_aggregate, $item_id);
            }

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Failed to update stock: " . mysqli_error($link));
            }
        } else {
            throw new Exception("Item not found in stock");
        }
    }

    // Handle kitchen items if it's a main dish
    if ($source === 'menu' && isset($item_category) && strtolower($item_category) === 'main dishes') {
        $update_kitchen_query = "UPDATE Kitchen SET quantity = quantity - ? WHERE item_id = ?";
        $stmt = mysqli_prepare($link, $update_kitchen_query);
        mysqli_stmt_bind_param($stmt, "is", $quantity, $item_id);
        
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Failed to update kitchen: " . mysqli_error($link));
        }

        // Delete if quantity reaches zero
        $check_query = "SELECT quantity FROM Kitchen WHERE item_id = ?";
        $stmt = mysqli_prepare($link, $check_query);
        mysqli_stmt_bind_param($stmt, "s", $item_id);
        mysqli_stmt_execute($stmt);
        $check_result = mysqli_stmt_get_result($stmt);
        
        if ($check_result && mysqli_num_rows($check_result) > 0) {
            $check_row = mysqli_fetch_assoc($check_result);
            if ($check_row['quantity'] <= 0) {
                $delete_query = "DELETE FROM Kitchen WHERE item_id = ?";
                $stmt = mysqli_prepare($link, $delete_query);
                mysqli_stmt_bind_param($stmt, "s", $item_id);
                mysqli_stmt_execute($stmt);
            }
        }
    }

    // Commit all changes
    mysqli_commit($link);
    header("Location: ../pendingOrderCrud/viewPendingOrder.php?order_id=$order_id");
    exit();
} catch (Exception $e) {
    mysqli_rollback($link);
    error_log("Delete Error: " . $e->getMessage());
    die("Failed to delete item: " . $e->getMessage());
}
?>