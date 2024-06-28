<?php
require_once 'db.php';

session_start();

// Check if the user is logged in, redirect to login if not
//if (!isset($_SESSION['user_id'])) {
  //  header("Location: login.php");
    //exit();
//}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $supplierId = $_POST['supplierId'];
    $supplierName = $_POST['supplierName'];
    $supplierEmail = $_POST['supplierEmail'];
    $supplierMobile = $_POST['supplierMobile'];
    $supplierContact = $_POST['supplierContact'];
    $supplierAddress = $_POST['supplierAddress'];
    $supplierDetails = isset($_POST['supplierDetails']) ? $_POST['supplierDetails'] : '';
    $supplierRemarks = isset($_POST['supplierRemarks']) ? $_POST['supplierRemarks'] : '';

    // Use prepared statement to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO suppliers (id, name, email, mobile, contact_no, address, details, remarks) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        echo "Error: " . $conn->error;
        exit(); // exit if prepare fails
    }

    // Bind parameters
    $stmt->bind_param("ssssssss", $supplierId, $supplierName, $supplierEmail, $supplierMobile, $supplierContact, $supplierAddress, $supplierDetails, $supplierRemarks);

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: add.html");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
