<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "warehouse_managers";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Connection failed, display error message
    die("Connection failed: " . $conn->connect_error);
} else {
    // Connection successful, proceed with database operations
    
    // Perform database queries here
}
// Close connection
?>
