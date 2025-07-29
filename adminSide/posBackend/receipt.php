<?php
session_start();
require('fpdf186/fpdf.php');
require_once '../config.php';

date_default_timezone_set('Africa/Khartoum');

// Check if bill_id is provided
if (!isset($_GET['bill_id'])) {
    die("Invalid Bill ID");
}

$bill_id = mysqli_real_escape_string($link, $_GET['bill_id']);

// Fetch bill details
$bill_query = "SELECT * FROM bills WHERE bill_id = '$bill_id'";
$bill_result = mysqli_query($link, $bill_query);
$bill_data = mysqli_fetch_assoc($bill_result);

if (!$bill_data) {
    die("Bill not found");
}

// Fetch creditor details if payment method is creditor
$creditor_name = '';
if ($bill_data['payment_method'] === 'creditor') {
    $creditor_id = $bill_data['creditor_id'];
    $creditor_query = "SELECT Name FROM creditors WHERE ID = '$creditor_id'";
    $creditor_result = mysqli_query($link, $creditor_query);
    if ($creditor_result && mysqli_num_rows($creditor_result) > 0) {
        $creditor_data = mysqli_fetch_assoc($creditor_result);
        $creditor_name = $creditor_data['Name'];
    }
}

// Fetch bill items
$items_query = "
    SELECT bi.item_id, 
           COALESCE(m.item_name, s.ItemName) AS item_name, 
           COALESCE(m.item_price, CASE WHEN bi.unit = 'base' THEN s.PricePerBaseUnit ELSE s.PricePerSubUnit END) AS item_price, 
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
           COALESCE(m.item_price, CASE WHEN poi.unit = 'base' THEN s.PricePerBaseUnit ELSE s.PricePerSubUnit END) AS item_price, 
           poi.quantity, 
           poi.source, 
           poi.unit
    FROM pendingorderitems poi
    LEFT JOIN menu m ON poi.item_id = m.item_id AND poi.source = 'menu'
    LEFT JOIN stock s ON poi.item_id = s.ItemID AND poi.source = 'stock'
    WHERE poi.order_id = (SELECT order_id FROM pendingorders WHERE bill_id = '$bill_id')
";
$items_result = mysqli_query($link, $items_query);

// Initialize PDF for 80mm width
$pdf = new FPDF('P', 'mm', array(80, 80));
$pdf->AddPage();
$pdf->SetMargins(3, 3, 3);
$pdf->SetAutoPageBreak(true, 3);

// Convert bill_time to local time
$bill_time_cat = 'N/A';
if (!empty($bill_data['bill_time'])) {
    $bill_time_obj = DateTime::createFromFormat('Y-m-d H:i:s', $bill_data['bill_time'], new DateTimeZone('UTC'));
    if ($bill_time_obj) {
        $bill_time_obj->setTimezone(new DateTimeZone('Africa/Khartoum'));
        $bill_time_cat = $bill_time_obj->format('d/m/Y H:i');
    }
}

// Restaurant Header
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(0, 4, "Cafe Maruu Restaurant", 0, 1, 'C');
$pdf->SetFont('Arial', '', 7);

// Receipt Info
$pdf->Cell(0, 3, 'Receipt: ' . $bill_data['bill_id'], 0, 1, 'L');
$pdf->Cell(0, 3, 'Date: ' . $bill_time_cat, 0, 1, 'L');
if (!empty($bill_data['table_id'])) {
    $pdf->Cell(0, 3, 'Table: ' . $bill_data['table_id'], 0, 1, 'L');
}
$pdf->Cell(0, 3, 'Staff: ' . $bill_data['staff_id'], 0, 1, 'L');

// Payment Info
$paymentMethod = strtoupper($bill_data['payment_method']);
$pdf->Cell(0, 3, 'Payment: ' . $paymentMethod, 0, 1, 'L');

// Creditor or Authorizing Staff
if ($bill_data['payment_method'] === 'creditor' && !empty($creditor_name)) {
    $pdf->Cell(0, 3, 'Creditor: ' . $creditor_name, 0, 1, 'L');
} elseif ($bill_data['payment_method'] === 'compo') {
    $authorizing_staff_id = $bill_data['authorizing_staff_id'];
    $staff_query = "SELECT staff_name FROM staffs WHERE staff_id = '$authorizing_staff_id'";
    $staff_result = mysqli_query($link, $staff_query);
    if ($staff_result && mysqli_num_rows($staff_result) > 0) {
        $staff_data = mysqli_fetch_assoc($staff_result);
        $pdf->Cell(0, 3, 'Auth Staff: ' . $staff_data['staff_name'], 0, 1, 'L');
    }
}

$pdf->Ln(1); // Small spacer

// Items Header - Different layout for compo vs non-compo
$pdf->SetFont('Arial', 'B', 7);
if ($bill_data['payment_method'] !== 'compo') {
    $pdf->Cell(32, 4, 'ITEM', 0);
    $pdf->Cell(15, 4, 'PRICE', 0, 0, 'R');
    $pdf->Cell(10, 4, 'QTY', 0, 0, 'R');
    $pdf->Cell(15, 4, 'TOTAL', 0, 0, 'R');
} else {
    $pdf->Cell(55, 4, 'ITEM', 0);
    $pdf->Cell(15, 4, 'QTY', 0, 0, 'R');
}
$pdf->Ln();
$pdf->Cell(0, 1, str_repeat('-', 72), 0, 1);

// Items List
$pdf->SetFont('Arial', '', 7);
$cart_total = 0;
while ($item_row = mysqli_fetch_assoc($items_result)) {
    $item_name = substr($item_row['item_name'], 0, 20);
    $quantity = $item_row['quantity'];
    
    if ($bill_data['payment_method'] !== 'compo') {
        $item_price = $item_row['item_price'];
        $total = $item_price * $quantity;
        $cart_total += $total;

        $pdf->Cell(32, 4, $item_name, 0);
        $pdf->Cell(15, 4, number_format($item_price, 0), 0, 0, 'R');
        $pdf->Cell(10, 4, $quantity, 0, 0, 'R');
        $pdf->Cell(15, 4, number_format($total, 0), 0, 0, 'R');
    } else {
        $pdf->Cell(55, 4, $item_name, 0);
        $pdf->Cell(15, 4, $quantity, 0, 0, 'R');
    }
    $pdf->Ln();
}

// Summary Section - Only for non-compo payments
if ($bill_data['payment_method'] !== 'compo') {
    $pdf->Cell(0, 1, str_repeat('-', 72), 0, 1);
    $pdf->SetFont('Arial', 'B', 8);
    
    $pdf->Cell(57, 5, 'SUBTOTAL:', 0);
    $pdf->Cell(15, 5, number_format($cart_total, 0), 0, 0, 'R');
    $pdf->Ln();

    // Tax for card payments
    if ($bill_data['payment_method'] === 'card') {
        $tax_rate = 0.05;
        $tax_amount = $cart_total * $tax_rate;
        $grand_total = $cart_total + $tax_amount;

        $pdf->Cell(57, 5, 'TAX (5%):', 0);
        $pdf->Cell(15, 5, number_format($tax_amount, 0), 0, 0, 'R');
        $pdf->Ln();

        $pdf->Cell(57, 5, 'GRAND TOTAL:', 0);
        $pdf->Cell(15, 5, number_format($grand_total, 0), 0, 0, 'R');
    } else {
        $pdf->Cell(57, 5, 'TOTAL:', 0);
        $pdf->Cell(15, 5, number_format($cart_total, 0), 0, 0, 'R');
    }
    $pdf->Ln();
}

// Footer
$pdf->Ln(2);
$pdf->SetFont('Arial', 'I', 6);
$pdf->Cell(0, 3, 'Thank you for dining with us!', 0, 1, 'C');
$pdf->Cell(0, 3, date('Y'), 0, 1, 'C');

// Output PDF
$pdf->Output('D', 'Receipt-'.$bill_id.'.pdf');
?>