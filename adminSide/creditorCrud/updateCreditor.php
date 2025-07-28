<?php
session_start(); // Ensure session is started
?>
<?php
// Include config file
require_once "../config.php";

// Initialize variables for form validation and creditor data
$id = $name = $due_amount = $telephone = "";
$id_err = "";

// Check if ID is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve creditor details based on ID
    $sql = "SELECT * FROM creditors WHERE ID = ?";
    
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $id;
        
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $name = $row['Name'];
                $due_amount = $row['Due_Amount'];
                $telephone = $row['Telephone'];
            } else {
                echo "Creditor not found.";
                exit();
            }
        } else {
            echo "Error retrieving creditor details.";
            exit();
        }
    }
}

// Process form submission when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $name = trim($_POST["name"]);
    $due_amount = floatval($_POST["due_amount"]); // Convert to float
    $telephone = trim($_POST["telephone"]);

    // Automatically set the current date and time
    $currentDate = date('Y-m-d H:i:s');

    // Update the creditor in the database
    $update_sql = "UPDATE creditors SET Name='$name', Due_Amount='$due_amount', Date='$currentDate', Telephone='$telephone' WHERE ID='$id'";
    $resultCreditor = mysqli_query($link, $update_sql);
    
    if ($resultCreditor) {
        // Creditor updated successfully
        header("Location: ../panel/creditors-panel.php");
        exit();
    } else {
        echo "Error updating creditor: " . mysqli_error($link);
    }
}
?>

<!-- Create your HTML form for updating the creditor details -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <title>Update Creditor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: black;
            color: white;
        }

        .login-container {
            padding: 50px; /* Adjust the padding as needed */
            border-radius: 10px; /* Add rounded corners */
            margin: 100px auto; /* Center the container horizontally */
            max-width: 500px; /* Set a maximum width for the container */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login_wrapper">
            <div class="wrapper">
                <h2 style="text-align: center;">Update Creditor</h2>
                <h5>Admin Credentials needed to Edit Creditor</h5>
                <form action="" method="post">
                    <!-- Name -->
                    <div class="form-group">
                        <label for="name" class="form-label">Creditor Name:</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter creditor's name" value="<?php echo htmlspecialchars($name); ?>" required>
                    </div>

                    <!-- Due Amount -->
                    <div class="form-group">
                        <label for="due_amount" class="form-label">Due Amount:</label>
                        <input type="number" min="0.0" step="0.0" name="due_amount" id="due_amount" class="form-control" placeholder="Enter due amount" value="<?php echo htmlspecialchars($due_amount); ?>" required>
                    </div>

                    <!-- Telephone -->
                    <div class="form-group">
                        <label for="telephone" class="form-label">Telephone:</label>
                        <input type="text" name="telephone" id="telephone" class="form-control" placeholder="Enter telephone number" value="<?php echo htmlspecialchars($telephone); ?>" required>
                    </div>

                    <!-- Hidden ID Field -->
                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                    <!-- Buttons -->
                    <div class="form-group">
                        <button class="btn btn-light" type="submit" name="submit" value="submit">Update</button>
                        <a class="btn btn-danger" href="../panel/creditors-panel.php">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>