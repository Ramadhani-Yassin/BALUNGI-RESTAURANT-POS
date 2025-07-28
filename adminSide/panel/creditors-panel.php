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
                <div class="mt-5 mb-3">
                    <h2 class="pull-left">Creditors Details</h2>
                    <a href="../creditorCrud/createCreditor.php" class="btn btn-outline-dark"><i class="fa fa-plus"></i> Add Creditor</a>
                </div>
                <div class="mb-3">
                    <form method="POST" action="#">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="search" id="search" class="form-control" placeholder="Search by Name, Telephone, or Due Amount">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-dark">Search</button>
                            </div>
                            <div class="col" style="text-align: right;" >
                                <a href="creditor-panel.php" class="btn btn-light">Show All</a>
                            </div>
                        </div>
                    </form>
                </div>
                <?php
                // Include config file
                require_once "../config.php";

                if (isset($_POST['search'])) {
                    if (!empty($_POST['search'])) {
                        $search = $_POST['search'];

                        $sql = "SELECT * FROM creditors WHERE Name LIKE '%$search%' OR Telephone LIKE '%$search%' OR Due_Amount LIKE '%$search%' ORDER BY ID;";
                    } else {
                        // Default query to fetch all creditors
                        $sql = "SELECT * FROM creditors ORDER BY ID;";
                    }
                } else {
                    // Default query to fetch all creditors
                    $sql = "SELECT * FROM creditors ORDER BY ID;";
                }

                if ($result = mysqli_query($link, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>ID</th>";
                        echo "<th>Name</th>";
                        echo "<th>Due Amount</th>";
                        echo "<th>Date</th>";
                        echo "<th>Telephone</th>";
                        echo "<th>Edit</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['ID'] . "</td>";
                            echo "<td>" . $row['Name'] . "</td>";
                            echo "<td>" . $row['Due_Amount'] . "</td>";
                            echo "<td>" . $row['Date'] . "</td>";
                            echo "<td>" . $row['Telephone'] . "</td>";
                            echo "<td>";
                            // Modify link with the pencil icon
                            echo '<a href="../creditorCrud/updateCreditorVerify.php?id='. $row['ID'] .'" title="Modify Record" data-toggle="tooltip"'
                                    . 'onclick="return confirm(\'Admin permission Required!\n\nAre you sure you want to Edit this Creditor?\')">'
                             . '<i class="fa fa-pencil" aria-hidden="true"></i></a>';
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        // Free result set
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