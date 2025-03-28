<?php
session_start(); // Ensure session is started
require('fpdf186/fpdf.php'); // Include FPDF library
require_once '../config.php'; // Include database configuration

// Set timezone to East African Time (EAT)
date_default_timezone_set('Africa/Nairobi');

// Fetch all stock items
$sql = "SELECT * FROM Stock ORDER BY ItemID";
$result = mysqli_query($link, $sql);

// Initialize PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Header
$pdf->Cell(0, 10, "BALUNGI Restaurant - Stock Report", 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 1, 'L');
$pdf->Ln();

// Table Header
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 10, 'ID', 1);
$pdf->Cell(60, 10, 'Item Name', 1); // Reduced width
$pdf->Cell(30, 10, 'Quantity', 1);
$pdf->Cell(30, 10, 'Price', 1);
$pdf->Cell(50, 10, 'Total', 1); // Increased width
$pdf->Ln();

// Table Rows
$pdf->SetFont('Arial', '', 12);
$totalValue = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $itemID = $row['ItemID'];
    $itemName = $row['ItemName'];
    $quantity = $row['BaseUnitQuantity'];
    $price = $row['PricePerBaseUnit'];
    $total = $quantity * $price;
    $totalValue += $total;

    $pdf->Cell(20, 10, $itemID, 1);
    $pdf->Cell(60, 10, $itemName, 1); // Reduced width
    $pdf->Cell(30, 10, $quantity, 1);
    $pdf->Cell(30, 10, 'TZS ' . number_format($price, 2), 1);
    $pdf->Cell(50, 10, 'TZS ' . number_format($total, 2), 1); // Increased width
    $pdf->Ln();
}

// Total Summary
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(140, 10, 'Total Stock Value:', 1); // Adjusted width
$pdf->Cell(50, 10, 'TZS ' . number_format($totalValue, 2), 1); // Increased width
$pdf->Ln();

// Output the PDF
$pdf->Output('Stock-Report-' . date('Y-m-d') . '.pdf', 'D');
?>
