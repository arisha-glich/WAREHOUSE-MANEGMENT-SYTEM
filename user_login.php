<?php
// Include database connection file
require_once '../db.php';

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL query to fetch user record by username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("s", $username);
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User found, verify password
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Password is correct, start session and redirect to dashboard
                session_start();
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                header("Location: user_dashboard.html");
                exit();
            } else {
                // Incorrect password
                ECHO"PASS";
                echo "Invalid username or password.";
            }
        } else {
            // User not found
            echo "Invalid username or password.";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Error in preparing SQL statement
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // Redirect to login page if accessed directly without form submission
    header("Location: user_login.html");
    exit();
}
?>
