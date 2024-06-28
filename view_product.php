<?php
require_once 'db.php';

header('Content-Type: application/json');

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';

// Construct the SQL query with search condition based on the selected filter
$sql = "SELECT * FROM products WHERE LOWER($filter) LIKE ?";
$params = ['s', '%' . strtolower($search) . '%'];

// Check if the date filter is provided
if (!empty($date)) {
    // Append date filter condition to the SQL query
    $sql .= " AND DATE($filter) = ?";
    $params[0] .= 's';
    $params[] = $date;
}

$stmt = $conn->prepare($sql);
if ($stmt) {
    // Bind parameters and execute the prepared statement
    $stmt->bind_param(...$params);
    $stmt->execute();

    // Get result set from the prepared statement
    $result = $stmt->get_result();

    // Initialize response array to store product data
    $products = [];

    // Iterate through each row of the result set and store product details in the response array
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    // Close the prepared statement
    $stmt->close();

    // Encode the response array as JSON and output the result
    echo json_encode(['products' => $products]);
} else {
    // Error handling if the prepared statement fails
    echo json_encode(['error' => 'Error preparing SQL statement: ' . $conn->error]);
}

// Close the database connection
$conn->close();
?>
