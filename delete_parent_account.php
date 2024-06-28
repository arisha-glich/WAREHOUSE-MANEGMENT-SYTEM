<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Parent Account</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../reports/report_header.css">
    <header>
    <nav>
        <div class="logo">Warehouse Inventory System</div>
        <ul class="nav-links">
            <li><a href="../dashboard.html">Home</a></li>
            <li><a href="../about.html">About</a></li>
            <li><a href="../contactus.html">Contact</a></li>
            <li><a href="../add_product.html">Product</a></li>
            <li><a href="../view_product.html">Reports</a></li>
        </ul>
    </nav>
</header>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #b3c2d4;
            
            min-height: 100vh;
        }

        form {
            width: 400px;
            padding: 100px;
            margin: auto;
            background-color: white;
            opacity: 0.9;
            font-size: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
      
      
        .form-container h2 {
            margin-top: 0; /* Remove default margin */
        }
    </style>
</head>
<body>

<header>
    <nav>
        <div class="logo">Warehouse Inventory System</div>
        <ul class="nav-links">
            <li><a href="../dashboard.html">Home</a></li>
            <li><a href="../about.html">About</a></li>
            <li><a href="../contactus.html">Contact</a></li>
            <li><a href="../add_product.html">Product</a></li>
            <li><a href="../view_product.html">Reports</a></li>
            <li><a href="parent_accounts.html">Parent Accounts</a></li>
            <li><a href="control_accounts.html">Control Accounts</a></li>
            <li><a href="ledger_accounts.html">Ledger Accounts</a></li>
        </ul>
    </nav>
</header>

<div class="form-container">
   

    <form id="deleteParentAccountForm">  <h2>Delete Parent Account</h2>
        <label for="accountId">Account ID:</label>
        <input type="text" id="accountId" name="accountId" required><br><br>

        <label for="accountName">Account Name:</label>
        <input type="text" id="accountName" name="accountName" required><br><br>

        <button type="submit" class="button-item">Delete Account</button>
    </form>

    <div id="deleteResponse"></div>
</div>

<footer>
    <p>Contact us at: your.email@example.com</p>
    <p>&copy; 2024 ABC Inventory System. All rights reserved.</p>
</footer>

<script>
    $(document).ready(function() {
        // Handle form submission
        $('#deleteParentAccountForm').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            // Get form data
            var formData = $(this).serialize();

            // Submit form data using AJAX
            $.ajax({
                type: 'POST',
                url: 'delete_parent_account.php',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    // Display response message
                    $('#deleteResponse').html(`<p>${response.message}</p>`);
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting parent account:', error);
                    alert('Deleted Succesfully. Please try again.');
                }
            });
        });
    });
</script>

<?php
// Database connection (replace with your database credentials)
require_once('../db.php');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission to delete parent account
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accountId = $_POST['accountId'];
    $accountName = $_POST['accountName'];

    // Delete parent account from the database
    $sql = "DELETE FROM parent_accounts WHERE id = $accountId AND account_name = '$accountName'";

    if ($conn->query($sql) === TRUE) {
        $response = array('message' => 'Parent account deleted successfully');
    } else {
        $response = array('message' => 'Error deleting parent account: ' . $conn->error);
    }

    // Close database connection
    $conn->close();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
</body>
</html>
