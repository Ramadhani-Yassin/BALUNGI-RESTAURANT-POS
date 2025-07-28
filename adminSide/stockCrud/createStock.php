<?php
session_start(); // Ensure session is started
?>
<?php include '../inc/dashHeader.php'; ?>
<?php
// Include config file
require_once "../config.php";

// Initialize variables for form validation
$itemName = $baseUnitQuantity = $conversionRatio = $pricePerBaseUnit = $pricePerSubUnit = "";
$itemName_err = $baseUnitQuantity_err = $conversionRatio_err = $pricePerBaseUnit_err = $pricePerSubUnit_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Item Name
    if (empty(trim($_POST["itemName"]))) {
        $itemName_err = "Item Name is required.";
    } else {
        $itemName = trim($_POST["itemName"]);
    }

    // Validate Base Unit Quantity
    if (empty(trim($_POST["baseUnitQuantity"]))) {
        $baseUnitQuantity_err = "Base Unit Quantity is required.";
    } elseif (!is_numeric(trim($_POST["baseUnitQuantity"]))) {
        $baseUnitQuantity_err = "Base Unit Quantity must be a numeric value.";
    } else {
        $baseUnitQuantity = trim($_POST["baseUnitQuantity"]);
    }

    // Validate Conversion Ratio
    if (empty(trim($_POST["conversionRatio"]))) {
        $conversionRatio_err = "Conversion Ratio is required.";
    } elseif (!is_numeric(trim($_POST["conversionRatio"]))) {
        $conversionRatio_err = "Conversion Ratio must be a numeric value.";
    } else {
        $conversionRatio = trim($_POST["conversionRatio"]);
    }

    // Validate Price Per Base Unit
    if (empty(trim($_POST["pricePerBaseUnit"]))) {
        $pricePerBaseUnit_err = "Price Per Base Unit is required.";
    } elseif (!is_numeric(trim($_POST["pricePerBaseUnit"]))) {
        $pricePerBaseUnit_err = "Price Per Base Unit must be a numeric value.";
    } else {
        $pricePerBaseUnit = trim($_POST["pricePerBaseUnit"]);
    }

    // Validate Price Per Sub Unit
    if (empty(trim($_POST["pricePerSubUnit"]))) {
        $pricePerSubUnit_err = "Price Per Sub Unit is required.";
    } elseif (!is_numeric(trim($_POST["pricePerSubUnit"]))) {
        $pricePerSubUnit_err = "Price Per Sub Unit must be a numeric value.";
    } else {
        $pricePerSubUnit = trim($_POST["pricePerSubUnit"]);
    }

    // Check for errors before inserting into the database
    if (empty($itemName_err) && empty($baseUnitQuantity_err) && empty($conversionRatio_err) && empty($pricePerBaseUnit_err) && empty($pricePerSubUnit_err)) {
        // Prepare the SQL query
        $sql = "INSERT INTO stock (ItemName, BaseUnitQuantity, ConversionRatio, PricePerBaseUnit, PricePerSubUnit) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement
            mysqli_stmt_bind_param($stmt, "siidd", $itemName, $baseUnitQuantity, $conversionRatio, $pricePerBaseUnit, $pricePerSubUnit);

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to success page
                header("location: success_create.php");
                exit();
            } else {
                echo "Error: " . mysqli_error($link);
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close the connection
    mysqli_close($link);
}
?>
<head>
    <meta charset="UTF-8">
    <title>Create New Stock Item</title>
    <style>
        .wrapper { width: 1300px; padding-left: 200px; padding-top: 80px; }
    </style>
</head>

<div class="wrapper">
    <h3>Create New Stock Item</h3>
    <p>Please fill in the stock item information properly.</p>

    <form method="POST" action="success_createStock.php" class="ht-600 w-50">
        <!-- Item Name -->
        <div class="form-group">
            <label for="itemName">Item Name:</label>
            <input type="text" name="itemName" id="itemName" class="form-control <?php echo (!empty($itemName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $itemName; ?>" placeholder="Enter item name" required>
            <span class="invalid-feedback"><?php echo $itemName_err; ?></span>
        </div>
        <br>
        <!-- Base Unit Quantity -->
        <div class="form-group">
            <label for="baseUnitQuantity">Base Unit Quantity:</label>
            <input type="number" name="baseUnitQuantity" id="baseUnitQuantity" class="form-control <?php echo (!empty($baseUnitQuantity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $baseUnitQuantity; ?>" placeholder="Enter base unit quantity" required>
            <span class="invalid-feedback"><?php echo $baseUnitQuantity_err; ?></span>
        </div>
        <br>
        <!-- Conversion Ratio -->
        <div class="form-group">
            <label for="conversionRatio">Conversion Ratio:</label>
            <input type="number" name="conversionRatio" id="conversionRatio" class="form-control <?php echo (!empty($conversionRatio_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $conversionRatio; ?>" placeholder="Enter conversion ratio" required>
            <span class="invalid-feedback"><?php echo $conversionRatio_err; ?></span>
        </div>
        <br>
        <!-- Price Per Base Unit -->
        <div class="form-group">
            <label for="pricePerBaseUnit">Price Per Base Unit:</label>
            <input type="number" step="0.01" name="pricePerBaseUnit" id="pricePerBaseUnit" class="form-control <?php echo (!empty($pricePerBaseUnit_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $pricePerBaseUnit; ?>" placeholder="Enter price per base unit" required>
            <span class="invalid-feedback"><?php echo $pricePerBaseUnit_err; ?></span>
        </div>
        <br>
        <!-- Price Per Sub Unit -->
        <div class="form-group">
            <label for="pricePerSubUnit">Price Per Sub Unit:</label>
            <input type="number" step="0.01" name="pricePerSubUnit" id="pricePerSubUnit" class="form-control <?php echo (!empty($pricePerSubUnit_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $pricePerSubUnit; ?>" placeholder="Enter price per sub unit" required>
            <span class="invalid-feedback"><?php echo $pricePerSubUnit_err; ?></span>
        </div>
        <br>
        <!-- Submit Button -->
        <div class="form-group">
            <input type="submit" class="btn btn-dark" value="Create Stock Item">
        </div>
    </form>
</div>

<?php include '../inc/dashFooter.php'; ?>