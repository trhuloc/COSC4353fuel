<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    if (empty($_POST["gallonsRequested"]) || empty($_POST["deliveryDate"])) {
        // Display error message and redirect back to form
        
        header("Location: fuel_quote_form.html?error=required");
        exit();
    }

    // Validate field types
    $gallonsRequested = filter_var($_POST["gallonsRequested"], FILTER_VALIDATE_INT);
    if ($gallonsRequested === false || $gallonsRequested <= 0) {
        // Display error message and redirect back to form
        //header("Location: fuel_quote_form.html?error=invalid");
        header("Location: gallon_requested_validation.html");
        exit();
    }

    $deliveryDate = $_POST["deliveryDate"];
    $today = date("Y-m-d"); // Current date
    if ($deliveryDate < $today) {
        // Display error message and redirect back to form
        header("Location: delivery_date_validation.html");
        exit();
    }


    // Proceed with processing the form data
    $deliveryDate = $_POST["deliveryDate"];
    $pricePerGallon = 2.3; // Predefined price per gallon

    // Calculate total amount due
    $totalAmountDue = $gallonsRequested * $pricePerGallon;

    // Here you can save the submitted data to the database if needed

    // Display a notification message
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Fuel Quote Form - Submission Confirmation</title>
        <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
        <style>
            .notification {
                background-color: #4CAF50;
                color: white;
                text-align: center;
                padding: 10px;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class="notification">Data submitted successfully!</div>
    </body>
    </html>';
    exit();
}
?>
