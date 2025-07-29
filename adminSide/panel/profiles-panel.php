<?php
session_start(); // Ensure session is started
require_once '../posBackend/checkIfLoggedIn.php';
include '../inc/dashHeader.php'; 
require_once '../config.php';
?>

<style>
    .wrapper {
        width: 50%; 
        padding-left: 200px; 
        padding-top: 20px;
    }
    .hidden-row {
        display: none;
    }
</style>

<div class="wrapper">
    <div class="container-fluid pt-5 pl-600">
        <div class="row">
            <div class="col-md-12">
                <div class="mt-5 mb-3">
                    <h2 class="pull-left">Creditor Details</h2>
                </div>
                <div class="mb-3">
                    <form method="get" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <input required type="text" id="search_term" name="search_term" class="form-control" placeholder="Enter Creditor ID or Name">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-dark">Search</button>
                            </div>
                            <div class="col" style="text-align: right;">
                                <a href="creditors-panel.php" class="btn btn-light" id="showAllBtn">Show All</a>
                            </div>
                        </div>
                    </form>
                </div>
                
                <?php
                if (isset($_GET['search_term']) && !empty($_GET['search_term'])) {
                    $searchTerm = trim($_GET['search_term']);
                    $query = "SELECT Name, Due_Amount, Date, Telephone FROM creditors WHERE ID = ? OR Name LIKE ?";
                    
                    if ($stmt = mysqli_prepare($link, $query)) {
                        $searchLike = "%" . $searchTerm . "%";
                        mysqli_stmt_bind_param($stmt, "ss", $searchTerm, $searchLike);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        
                        if (mysqli_num_rows($result) == 0) {
                            echo '<div class="alert alert-danger"><em>No matching creditor found.</em></div>';
                        } else {
                            echo '<h3>Creditor Details</h3>';
                            echo '<table class="table table-bordered table-striped">';
                            echo '<thead><tr><th>Name</th><th>Due Amount</th><th>Date</th><th>Telephone</th><th>Action</th></tr></thead><tbody>';
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($row['Name']) . '</td>';
                                echo '<td>' . number_format($row['Due_Amount'], 2) . '</td>';
                                echo '<td>' . htmlspecialchars($row['Date']) . '</td>';
                                echo '<td>' . ($row['Telephone'] ? htmlspecialchars($row['Telephone']) : 'N/A') . '</td>';
                                echo '<td><button class="btn btn-secondary closeBtn">Close</button></td>';
                                echo '</tr>';
                            }
                            
                            echo '</tbody></table>';
                        }
                        mysqli_stmt_close($stmt);
                    }
                }
                ?>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <h3>Top 5 Creditors by Due Amount</h3>
                <div style="width: 100%; height: 400px;">
                    <canvas id="creditorsDebtChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    <?php
    $creditorsQuery = "SELECT Name, Due_Amount FROM creditors ORDER BY Due_Amount DESC LIMIT 5";
    $creditorsResult = mysqli_query($link, $creditorsQuery);

    $creditorLabels = [];
    $creditorData = [];

    while ($row = mysqli_fetch_assoc($creditorsResult)) {
        array_push($creditorLabels, $row['Name']);
        array_push($creditorData, $row['Due_Amount']);
    }
    ?>

    var ctx = document.getElementById('creditorsDebtChart');
    var creditorsDebtChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($creditorLabels); ?>,
            datasets: [{
                label: 'Due Amount (TZS)',
                data: <?php echo json_encode($creditorData); ?>,
                backgroundColor: ['rgb(8, 32, 50)', 'rgb(255, 76, 41)', 'rgb(13, 18, 130)', 'rgb(143, 67, 238)', 'rgb(179, 19, 18)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Due Amount (TZS)' }
                },
                x: {
                    title: { display: true, text: 'Creditors' }
                }
            }
        }
    });

    // Close button functionality
    document.querySelectorAll('.closeBtn').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('tr').classList.add('hidden-row');
        });
    });

    // Show All button functionality
    document.getElementById('showAllBtn').addEventListener('click', function(event) {
        event.preventDefault();
        document.querySelectorAll('.hidden-row').forEach(row => {
            row.classList.toggle('hidden-row');
        });
    });
</script>

<?php include '../inc/dashFooter.php'; ?>