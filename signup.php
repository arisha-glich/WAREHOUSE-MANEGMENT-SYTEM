<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "warehouse_managers";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $contactNo = $_POST['contactNo'];
    $id = $_POST['id'];
    $password = $_POST['password'];

    // Perform database insert operation
    $sql = "INSERT INTO user_data (name, contactNo, id, password) VALUES ('$name', '$contactNo', '$id', '$password')";
    if (mysqli_query($conn, $sql)) {
        header("Location: login.html");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else { 
    echo "Invalid request method";  
}

// Close the connection after all database operations
$conn->close();
?>
