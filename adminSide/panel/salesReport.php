<?php
session_start(); // Ensure session is started
require_once '../posBackend/checkIfLoggedIn.php';
?>
<?php include '../inc/dashHeader.php'; 
require_once '../config.php';

// Set default timezone
date_default_timezone_set('Africa/Dar_es_Salaam');

// Function to get sales data
function getSalesData($link, $period) {
    $query = "SELECT 
                DATE(payment_time) as sale_date,
                SUM(payment_amount) as total_sales,
                SUM(tax_amount) as total_tax,
                COUNT(*) as transaction_count,
                payment_method
              FROM payment_records
              WHERE ";
    
    $currentDate = date('Y-m-d');
    $params = [];
    
    switch ($period) {
        case 'today':
            $query .= "DATE(payment_time) = ?";
            $params[] = $currentDate;
            break;
        case 'yesterday':
            $query .= "DATE(payment_time) = DATE_SUB(?, INTERVAL 1 DAY)";
            $params[] = $currentDate;
            break;
        case 'week':
            $query .= "YEARWEEK(payment_time, 1) = YEARWEEK(?, 1)";
            $params[] = $currentDate;
            break;
        case 'month':
            $query .= "YEAR(payment_time) = YEAR(?) AND MONTH(payment_time) = MONTH(?)";
            $params[] = $currentDate;
            $params[] = $currentDate;
            break;
        case 'year':
            $query .= "YEAR(payment_time) = YEAR(?)";
            $params[] = $currentDate;
            break;
        case 'custom':
            $startDate = $_POST['start_date'] ?? $currentDate;
            $endDate = $_POST['end_date'] ?? $currentDate;
            $query .= "DATE(payment_time) BETWEEN ? AND ?";
            $params[] = $startDate;
            $params[] = $endDate;
            break;
    }
    
    $query .= " GROUP BY DATE(payment_time), payment_method ORDER BY sale_date DESC";
    
    $stmt = $link->prepare($query);
    if (count($params) > 0) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    $grandTotal = 0;
    $grandTax = 0;
    $totalTransactions = 0;
    
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
        $grandTotal += $row['total_sales'];
        $grandTax += $row['total_tax'];
        $totalTransactions += $row['transaction_count'];
    }
    
    return [
        'data' => $data,
        'grandTotal' => $grandTotal,
        'grandTax' => $grandTax,
        'totalTransactions' => $totalTransactions
    ];
}

// Get period from request or default to today
$period = $_GET['period'] ?? 'today';
$salesData = getSalesData($link, $period);

// Handle custom date range form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['custom_range'])) {
    $period = 'custom';
    $salesData = getSalesData($link, $period);
}
?>

<style>
    .report-container {
        margin-top: 6rem;
        padding-top: 30px;
        padding-left: 150px;
        padding-right: 20px;
    }
    
    .report-card {
        border-radius: 0;
        border: 1px solid #ddd;
        box-shadow: none;
    }
    
    .card-header {
        background-color: #fff !important;
        border-bottom: 1px solid #ddd;
        color: #000 !important;
        padding: 15px 20px;
    }
    
    .card-title {
        font-weight: 600;
        margin: 0;
    }
    
    .period-selector .btn {
        margin: 0 5px 5px 0;
        background-color: #fff;
        color: #000;
        border: 1px solid #ddd;
        border-radius: 0;
        padding: 8px 15px;
    }
    
    .period-selector .btn:hover {
        background-color: #000;
        color: #fff;
        border-color: #000;
    }
    
    .period-selector .btn-outline-primary {
        background-color: #fff;
        color: #000;
        border: 1px solid #ddd;
    }
    
    .period-selector .btn-primary {
        background-color: #000;
        color: #fff;
        border-color: #000;
    }
    
    .table {
        border: 1px solid #ddd;
    }
    
    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 1px solid #ddd;
        font-weight: 600;
    }
    
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #ddd;
    }
    
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0,0,0,.02);
    }
    
    .btn-danger {
        background-color: #000;
        color: #fff;
        border: 1px solid #000;
        border-radius: 0;
        padding: 8px 15px;
    }
    
    .btn-danger:hover {
        background-color: #333;
        border-color: #333;
    }
    
    .form-control {
        border-radius: 0;
        border: 1px solid #ddd;
    }
    
    .input-group-append .btn {
        border-radius: 0;
    }
    
    .payment-method {
        font-weight: bold;
    }
</style>

<div class="container report-container">
    <div class="row">
        <div class="col-md-12">
            <div class="card report-card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Café Maruu Sales Reports</h3>
                </div>
                <div class="card-body">
                    <!-- Period Selector -->
                    <div class="period-selector mb-4">
                        <a href="?period=today" class="btn <?= $period === 'today' ? 'btn-primary' : 'btn-outline-primary' ?>">Today</a>
                        <a href="?period=yesterday" class="btn <?= $period === 'yesterday' ? 'btn-primary' : 'btn-outline-primary' ?>">Yesterday</a>
                        <a href="?period=week" class="btn <?= $period === 'week' ? 'btn-primary' : 'btn-outline-primary' ?>">This Week</a>
                        <a href="?period=month" class="btn <?= $period === 'month' ? 'btn-primary' : 'btn-outline-primary' ?>">This Month</a>
                        <a href="?period=year" class="btn <?= $period === 'year' ? 'btn-primary' : 'btn-outline-primary' ?>">This Year</a>
                        
                        <!-- Custom Date Range Form -->
                        <form method="post" class="form-inline d-inline-block">
                            <div class="input-group ml-2">
                                <input type="date" name="start_date" class="form-control" value="<?= $_POST['start_date'] ?? date('Y-m-d') ?>">
                                <input type="date" name="end_date" class="form-control" value="<?= $_POST['end_date'] ?? date('Y-m-d') ?>">
                                <div class="input-group-append">
                                    <button type="submit" name="custom_range" class="btn btn-dark">Custom Range</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Total Sales</h5>
                                    <h2 class="card-text">TZS <?= number_format($salesData['grandTotal'], 2) ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Total Tax</h5>
                                    <h2 class="card-text">TZS <?= number_format($salesData['grandTax'], 2) ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Transactions</h5>
                                    <h2 class="card-text"><?= $salesData['totalTransactions'] ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Detailed Report Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Payment Method</th>
                                    <th>Transactions</th>
                                    <th>Tax</th>
                                    <th>Total Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($salesData['data'])): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No sales data available for this period</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($salesData['data'] as $row): ?>
                                        <tr>
                                            <td><?= date('M j, Y', strtotime($row['sale_date'])) ?></td>
                                            <td>
                                                <span class="payment-method">
                                                    <?= ucfirst($row['payment_method']) ?>
                                                </span>
                                            </td>
                                            <td><?= $row['transaction_count'] ?></td>
                                            <td>TZS <?= number_format($row['total_tax'], 2) ?></td>
                                            <td>TZS <?= number_format($row['total_sales'], 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Export Button - PDF Only -->
                    <div class="mt-4">
                        <a href="exportSales.php?period=<?= $period ?>" class="btn btn-danger">
                            <i class="fas fa-file-pdf"></i> Export as PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../inc/dashFooter.php'; ?>