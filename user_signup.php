<?php
// Include database connection file
require_once '../db.php';

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Prepare and execute SQL query to insert new user into database
    $sql = "INSERT INTO users (username, password, full_name, email, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("sssss", $username, $password, $fullName, $email, $role);
        if ($stmt->execute()) {
            // Redirect user to login page after successful registration
            header("Location: user_login.html");
            exit(); // Stop further script execution
        } else {
            // Display error message if execution fails
            echo "Error: " . $stmt->error;
        }
    } else {
        // Display error message if SQL query preparation fails
        echo "Error: " . $conn->error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
