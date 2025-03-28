<?php
session_start(); // Ensure session is started
?>
<?php
// Include config file
require_once "../config.php";

// Initialize variables for form validation and stock data
$itemID = $itemName = $baseUnitQuantity = $conversionRatio = $pricePerBaseUnit = $pricePerSubUnit = "";
$itemID_err = "";

// Check if ItemID is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $itemID = $_GET['id'];

    // Retrieve stock item details based on ItemID
    $sql = "SELECT * FROM stock WHERE ItemID = ?";
    
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_itemID);
        $param_itemID = $itemID;
        
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $itemName = $row['ItemName'];
                $baseUnitQuantity = $row['BaseUnitQuantity'];
                $conversionRatio = $row['ConversionRatio'];
                $pricePerBaseUnit = $row['PricePerBaseUnit'];
                $pricePerSubUnit = $row['PricePerSubUnit'];
            } else {
                echo "Stock item not found.";
                exit();
            }
        } else {
            echo "Error retrieving stock item details.";
            exit();
        }
    }
}

// Process form submission when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $itemName = trim($_POST["itemName"]);
    $baseUnitQuantity = intval($_POST["baseUnitQuantity"]); // Convert to integer
    $conversionRatio = intval($_POST["conversionRatio"]); // Convert to integer
    $pricePerBaseUnit = floatval($_POST["pricePerBaseUnit"]); // Convert to float
    $pricePerSubUnit = floatval($_POST["pricePerSubUnit"]); // Convert to float

    // Update the stock item in the database
    $update_sql = "UPDATE stock SET ItemName='$itemName', BaseUnitQuantity='$baseUnitQuantity', ConversionRatio='$conversionRatio', PricePerBaseUnit='$pricePerBaseUnit', PricePerSubUnit='$pricePerSubUnit' WHERE ItemID='$itemID'";
    $resultStock = mysqli_query($link, $update_sql);
    
    if ($resultStock) {
        // Stock item updated successfully
        header("Location: ../panel/stock-panel.php");
        exit();
    } else {
        echo "Error updating stock item: " . mysqli_error($link);
    }
}
?>

<!-- Create your HTML form for updating the stock item details -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <title>Update Stock Item</title>
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
                <h2 style="text-align: center;">Update Stock Item</h2>
                <h5>Admin Credentials needed to Edit Stock Item</h5>
                <form action="" method="post">
                    <!-- Item Name -->
                    <div class="form-group">
                        <label for="itemName" class="form-label">Item Name:</label>
                        <input type="text" name="itemName" id="itemName" class="form-control" placeholder="Enter item name" value="<?php echo htmlspecialchars($itemName); ?>" required>
                    </div>

                    <!-- Base Unit Quantity -->
                    <div class="form-group">
                        <label for="baseUnitQuantity" class="form-label">Base Unit Quantity:</label>
                        <input type="number" name="baseUnitQuantity" id="baseUnitQuantity" class="form-control" placeholder="Enter base unit quantity" value="<?php echo htmlspecialchars($baseUnitQuantity); ?>" required>
                    </div>

                    <!-- Conversion Ratio -->
                    <div class="form-group">
                        <label for="conversionRatio" class="form-label">Conversion Ratio:</label>
                        <input type="number" name="conversionRatio" id="conversionRatio" class="form-control" placeholder="Enter conversion ratio" value="<?php echo htmlspecialchars($conversionRatio); ?>" required>
                    </div>

                    <!-- Price Per Base Unit -->
                    <div class="form-group">
                        <label for="pricePerBaseUnit" class="form-label">Price Per Base Unit:</label>
                        <input type="number" step="0.01" name="pricePerBaseUnit" id="pricePerBaseUnit" class="form-control" placeholder="Enter price per base unit" value="<?php echo htmlspecialchars($pricePerBaseUnit); ?>" required>
                    </div>

                    <!-- Price Per Sub Unit -->
                    <div class="form-group">
                        <label for="pricePerSubUnit" class="form-label">Price Per Sub Unit:</label>
                        <input type="number" step="0.01" name="pricePerSubUnit" id="pricePerSubUnit" class="form-control" placeholder="Enter price per sub unit" value="<?php echo htmlspecialchars($pricePerSubUnit); ?>" required>
                    </div>

                    <!-- Hidden ItemID Field -->
                    <input type="hidden" name="itemID" value="<?php echo $itemID; ?>">

                    <!-- Buttons -->
                    <div class="form-group">
                        <button class="btn btn-light" type="submit" name="submit" value="submit">Update</button>
                        <a class="btn btn-danger" href="../panel/stock-panel.php">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>