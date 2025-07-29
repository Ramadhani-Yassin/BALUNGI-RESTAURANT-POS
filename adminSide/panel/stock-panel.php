<?php
session_start(); // Ensure session is started
require_once '../posBackend/checkIfLoggedIn.php';
?>
<?php include '../inc/dashHeader.php'; ?>
    <style>
        .wrapper{ width: 1300px; padding-left: 200px; padding-top: 20px  }
    </style>

<div class="wrapper">
    <div class="container-fluid pt-5 pl-600">
        <div class="row">
            <div class="m-50">

                <!--<div class="mt-5 mb-3">
                    <h2 class="pull-left">Stock Details</h2>
                    <a href="../stockCrud/createStock.php" class="btn btn-outline-dark"><i class="fa fa-plus"></i> Add Stock</a>
                </div>-->
                
            <div class="mt-5 mb-3 d-flex justify-content-between align-items-center">
                 <h2 class="m-0">Stock Details</h2>
                <div>
                <a href="../stockCrud/createStock.php" class="btn btn-outline-dark"><i class="fa fa-plus"></i> Add Stock</a>
                <a href="../posBackend/generateStockReport.php" class="btn btn-outline-success"><i class="fa fa-print"></i> Print Stock Record</a>
                </div>
             </div>
                
                <div class="mb-3">
                    <form method="POST" action="#">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="search" id="search" class="form-control" placeholder="Search by Item Name or ID">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-dark">Search</button>
                            </div>
                            <div class="col" style="text-align: right;" >
                                <a href="stock.php" class="btn btn-light">Show All</a>
                            </div>
                        </div>
                    </form>
                </div>
                <?php
                // Include config file
                require_once "../config.php";

                if (isset($_POST['search']) && !empty($_POST['search'])) {
                    $search = $_POST['search'];
                    $sql = "SELECT * FROM stock WHERE ItemName LIKE '%$search%' OR ItemID LIKE '%$search%' ORDER BY ItemID";
                } else {
                    $sql = "SELECT * FROM stock ORDER BY ItemID";
                }

                if ($result = mysqli_query($link, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Item ID</th>";
                        echo "<th>Name</th>";
                        echo "<th>Base Unit Quantity</th>";
                        echo "<th>Conversion Ratio</th>";
                        echo "<th>Aggregate Quantity</th>";
                        echo "<th>Price Per Base Unit</th>";
                        echo "<th>Price Per Sub Unit</th>";
                        echo "<th>Edit</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['ItemID'] . "</td>";
                            echo "<td>" . $row['ItemName'] . "</td>";
                            echo "<td>" . $row['BaseUnitQuantity'] . "</td>";
                            echo "<td>" . $row['ConversionRatio'] . "</td>";
                            echo "<td>" . ($row['AggregateQuantity'] ?? 'N/A') . "</td>";
                            echo "<td>" . $row['PricePerBaseUnit'] . "</td>";
                            echo "<td>" . $row['PricePerSubUnit'] . "</td>";
                            echo "<td>";
                            echo '<a href="../stockCrud/updateStock.php?id='. $row['ItemID'] .'" title="Modify Record" data-toggle="tooltip" onclick="return confirm(\'Admin permission required!\n\nAre you sure you want to edit this stock item?\')">'
                                    . '<i class="fa fa-pencil" aria-hidden="true"></i></a>';
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        mysqli_free_result($result);
                    } else {
                        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close connection
                mysqli_close($link);
                ?>
            </div>
        </div>
    </div>
</div>

<?php include '../inc/dashFooter.php'; ?>
