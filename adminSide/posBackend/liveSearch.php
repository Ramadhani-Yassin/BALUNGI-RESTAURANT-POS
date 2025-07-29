<?php
require_once '../config.php';

$search = isset($_POST['search']) ? $_POST['search'] : '';
$bill_id = isset($_POST['bill_id']) ? $_POST['bill_id'] : '';

if (!empty($search)) {
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

    if ($result && mysqli_num_rows($result) > 0) {
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