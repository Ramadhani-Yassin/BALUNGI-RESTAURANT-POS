<?php
// Custom error handler for fatal errors
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    // Only handle fatal errors
    if ($errno == E_ERROR || $errno == E_PARSE || $errno == E_CORE_ERROR || 
        $errno == E_COMPILE_ERROR || $errno == E_USER_ERROR) {
        
        // Log the error
        error_log("Fatal Error: $errstr in $errfile on line $errline");
        
        // Redirect to error page
        $error_details = urlencode("$errstr in $errfile on line $errline");
        header("Location: /chwaka-inventory/error_page.php?code=500&details=$error_details");
        exit();
    }
    
    return false; // Let PHP handle other errors
}

// Custom exception handler
function customExceptionHandler($exception) {
    // Log the exception
    error_log("Uncaught Exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine());
    
    // Redirect to error page
    $error_details = urlencode($exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine());
    header("Location: /chwaka-inventory/error_page.php?code=500&details=$error_details");
    exit();
}

// Set the error handlers
set_error_handler("customErrorHandler");
set_exception_handler("customExceptionHandler");

// Function to handle database connection errors
function handleDatabaseError($error_message) {
    error_log("Database Error: $error_message");
    $error_details = urlencode($error_message);
    header("Location: /chwaka-inventory/error_page.php?code=500&details=$error_details");
    exit();
}

// Function to handle permission errors
function handlePermissionError($message = "Access denied") {
    error_log("Permission Error: $message");
    header("Location: /chwaka-inventory/error_page.php?code=403&details=" . urlencode($message));
    exit();
}

// Function to handle not found errors
function handleNotFoundError($message = "Page not found") {
    error_log("Not Found Error: $message");
    header("Location: /chwaka-inventory/error_page.php?code=404&details=" . urlencode($message));
    exit();
}
?> 