<?php
session_start();
require_once '../config.php';

// Check if required parameters are provided
if (isset($_GET['bill_item_id']) && isset($_GET['bill_id']) && isset($_GET['item_id'])) {
    $bill_item_id = intval($_GET['bill_item_id']);
    $bill_id = intval($_GET['bill_id']);
    $item_id = $_GET['item_id'];
    $table_id = isset($_GET['table_id']) ? intval($_GET['table_id']) : null; // Optional table_id

    // Fetch the quantity, source, and unit of the item being deleted
    $fetch_query = "SELECT quantity, source, unit FROM bill_items WHERE bill_item_id = '$bill_item_id' AND bill_id = '$bill_id'";
    $fetch_result = mysqli_query($link, $fetch_query);

    if ($fetch_result && mysqli_num_rows($fetch_result) > 0) {
        $row = mysqli_fetch_assoc($fetch_result);
        $quantity = intval($row['quantity']);
        $source = $row['source'];
        $unit = $row['unit'];

        // Delete the item from the bill_items table
        $delete_query = "DELETE FROM bill_items WHERE bill_item_id = '$bill_item_id'";
        if (mysqli_query($link, $delete_query)) {
            // Delete the corresponding item from the Kitchen table
            $delete_kitchen_query = "DELETE FROM Kitchen WHERE item_id = '$item_id' AND (table_id = '$table_id' OR table_id IS NULL)";
            if (mysqli_query($link, $delete_kitchen_query)) {
                // If the item is from stock, update the stock quantity based on the unit
                if ($source === 'stock') {
                    // Start a transaction to ensure data consistency
                    mysqli_begin_transaction($link);
                
                    try {
                        // Fetch current stock details
                        $stock_query = "SELECT BaseUnitQuantity, ConversionRatio, AggregateQuantity, PendingAggregate FROM stock WHERE ItemID = ?";
                        $stmt = mysqli_prepare($link, $stock_query);
                        mysqli_stmt_bind_param($stmt, "s", $item_id);
                        mysqli_stmt_execute($stmt);
                        $stock_result = mysqli_stmt_get_result($stmt);
                
                        if ($stock_result && mysqli_num_rows($stock_result) > 0) {
                            $stock_row = mysqli_fetch_assoc($stock_result);
                            $base_quantity = (int) $stock_row['BaseUnitQuantity'];
                            $conversion_ratio = (int) $stock_row['ConversionRatio'];
                            $aggregate_quantity = (int) $stock_row['AggregateQuantity'];
                            $pending_aggregate = (int) $stock_row['PendingAggregate']; // Newly introduced column to track pending aggregates
                
                            if ($unit === 'base') {
                                // Increase base quantity when base unit is deleted from cart
                                $new_base_quantity = $base_quantity + $quantity;
                                $update_stock_query = "UPDATE stock SET BaseUnitQuantity = ? WHERE ItemID = ?";
                            } elseif ($unit === 'aggregate') {
                                // Handle pending aggregate reduction
                                $new_pending_aggregate = $pending_aggregate - $quantity;
                                
                                if ($new_pending_aggregate < 0) {
                                    // Ensure it doesn't go negative
                                    $new_pending_aggregate = 0;
                                }
                
                                // If pending aggregates sum up to a full conversion ratio, convert them to base units
                                $convert_to_base = floor($new_pending_aggregate / $conversion_ratio);
                                $new_base_quantity = $base_quantity + $convert_to_base;
                                $new_aggregate_quantity = $aggregate_quantity + $quantity - ($convert_to_base * $conversion_ratio);
                
                                // Update both Aggregate and Base units
                                $update_stock_query = "UPDATE stock SET BaseUnitQuantity = ?, AggregateQuantity = ?, PendingAggregate = ? WHERE ItemID = ?";
                            }
                
                            // Prepare the update statement
                            $stmt_update = mysqli_prepare($link, $update_stock_query);
                
                            if ($unit === 'base') {
                                mysqli_stmt_bind_param($stmt_update, "is", $new_base_quantity, $item_id);
                            } elseif ($unit === 'aggregate') {
                                mysqli_stmt_bind_param($stmt_update, "iiis", $new_base_quantity, $new_aggregate_quantity, $new_pending_aggregate, $item_id);
                            }
                
                            // Execute the update query
                            if (!mysqli_stmt_execute($stmt_update)) {
                                throw new Exception("Error updating stock: " . mysqli_error($link));
                            }
                
                            // Commit transaction
                            mysqli_commit($link);
                        } else {
                            throw new Exception("Item not found in stock!");
                        }
                    } catch (Exception $e) {
                        mysqli_rollback($link);
                        error_log($e->getMessage());
                        header("Location: orderItem.php?bill_id=$bill_id&delete_error=1&table_id=$table_id");
                        exit();
                    }
                }
                

                // Redirect back to the orderItem.php page with a success message
                header("Location: orderItem.php?bill_id=$bill_id&delete_success=1&table_id=$table_id");
                exit();
            } else {
                // Log the error if Kitchen table deletion fails
                error_log("Error deleting from Kitchen: " . mysqli_error($link));
                header("Location: orderItem.php?bill_id=$bill_id&delete_error=1&table_id=$table_id");
                exit();
            }
        } else {
            // Log the error if bill_items table deletion fails
            error_log("Error deleting from bill_items: " . mysqli_error($link));
            header("Location: orderItem.php?bill_id=$bill_id&delete_error=1&table_id=$table_id");
            exit();
        }
    } else {
        // Log the error if the item is not found in the cart
        error_log("Item not found in cart: bill_item_id = $bill_item_id, bill_id = $bill_id");
        header("Location: orderItem.php?bill_id=$bill_id&delete_error=1&table_id=$table_id");
        exit();
    }
} else {
    // Log the error if required parameters are missing
    error_log("Missing parameters in deleteItem.php: bill_item_id, bill_id, or item_id not provided.");
    header("Location: orderItem.php?bill_id=" . (isset($_GET['bill_id']) ? $_GET['bill_id'] : '') . "&delete_error=1&table_id=" . (isset($_GET['table_id']) ? $_GET['table_id'] : ''));
    exit();
}
?>