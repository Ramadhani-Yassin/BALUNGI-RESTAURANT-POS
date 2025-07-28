<?php
session_start(); // Ensure session is started
?>
<?php include '../inc/dashHeader.php'; ?>
<?php
// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$name = $due_amount = $telephone = "";
$name_err = $due_amount_err = $telephone_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter the creditor's name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate Due Amount
    if (empty(trim($_POST["due_amount"]))) {
        $due_amount_err = "Please enter the due amount.";
    } elseif (!is_numeric(trim($_POST["due_amount"]))) {
        $due_amount_err = "Due amount must be a numeric value.";
    } else {
        $due_amount = trim($_POST["due_amount"]);
    }

    // Validate Telephone
    if (empty(trim($_POST["telephone"]))) {
        $telephone_err = "Please enter the telephone number.";
    } else {
        $telephone = trim($_POST["telephone"]);
    }

    // Check input errors before inserting into database
    if (empty($name_err) && empty($due_amount_err) && empty($telephone_err)) {
        // Get the current date and time
        $currentDate = date('Y-m-d H:i:s'); // Automatically set the current date and time

        // Prepare an insert statement
        $sql = "INSERT INTO creditors (Name, Due_Amount, Date, Telephone) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sdss", $param_name, $param_due_amount, $param_date, $param_telephone);

            // Set parameters
            $param_name = $name;
            $param_due_amount = $due_amount;
            $param_date = $currentDate; // Automatically set the current date and time
            $param_telephone = $telephone;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to success page
                header("location: success_create.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>
<head>
    <meta charset="UTF-8">
    <title>Create New Creditor</title>
    <style>
        .wrapper { width: 1300px; padding-left: 200px; padding-top: 80px; }
    </style>
</head>

<div class="wrapper">
    <h3>Create New Creditor</h3>
    <p>Please fill in the creditor's information properly.</p>

    <form method="POST" action="success_createCreditor.php" class="ht-600 w-50">
        <!-- Name -->
        <div class="form-group">
            <label for="name">Creditor Name:</label>
            <input type="text" name="name" id="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>" placeholder="Enter creditor's name">
            <span class="invalid-feedback"><?php echo $name_err; ?></span>
        </div>
        <br>
        <!-- Due Amount -->
        <div class="form-group">
            <label for="due_amount">Due Amount:</label>
            <input type="number" name="due_amount" id="due_amount" class="form-control <?php echo (!empty($due_amount_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $due_amount; ?>" placeholder="Enter due amount" step="0.01">
            <span class="invalid-feedback"><?php echo $due_amount_err; ?></span>
        </div>
        <br>
        <!-- Telephone -->
        <div class="form-group">
            <label for="telephone">Telephone:</label>
            <input type="text" name="telephone" id="telephone" class="form-control <?php echo (!empty($telephone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $telephone; ?>" placeholder="Enter telephone number">
            <span class="invalid-feedback"><?php echo $telephone_err; ?></span>
        </div>
        <br>
        <!-- Submit Button -->
        <div class="form-group">
            <input type="submit" class="btn btn-dark" value="Create Creditor">
        </div>
    </form>
</div>

<?php include '../inc/dashFooter.php'; ?>