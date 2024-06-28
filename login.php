<?php
require_once 'db.php';
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM user_data WHERE id = ? AND password = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $user_id, $password); // Bind parameters
        $stmt->execute(); // Execute the prepared statement

        $result = $stmt->get_result(); // Get result set

        if ($result->num_rows == 1) {
            // User found, set session variables and redirect to dashboard
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['id']; 
            $_SESSION['password'] = $password; 
            header("Location: dashboard.html");
            exit(); // Ensure that script stops execution after redirect
        } else {
            $error_message = "Incorrect user ID or password!";
        }

        $stmt->close(); // Close the prepared statement
    } else {
        $error_message = "Error preparing the statement: " . $conn->error;
    }
} else {
    $error_message = "Invalid request!";
}

$conn->close(); // Close the database connection
?>