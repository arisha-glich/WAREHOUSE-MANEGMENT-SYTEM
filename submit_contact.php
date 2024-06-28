<?php
// Include database connection file (assuming 'db.php' contains your database connection code)
require_once 'db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Prepare SQL statement to insert contact message into the database
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("sss", $name, $email, $message);
        
        if ($stmt->execute()) {
            // Message inserted successfully
            header("Location: add.html");
        } else {
            // Error executing the insert statement
            echo "Error inserting message: " . $stmt->error;
        }
        
        // Close the prepared statement
        $stmt->close();
    } else {
        // Error preparing the insert statement
        echo "Error preparing the insert statement: " . $conn->error;
    }
} else {
    // Invalid request method
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
