\<?php
require_once 'db.php';

// Initialize response array to store product data
$response = array('products' => array());

// Check if the search item and filter are provided via GET request
if (isset($_GET['search']) && isset($_GET['filter'])) {
    // Sanitize and retrieve search item and filter from GET parameters
    $search = $_GET['search'];
    $filter = $_GET['filter'];

    // Prepare SQL query based on the selected filter
    switch ($filter) {
        case 'name':
        case 'description':
        case 'category':
        case 'brand':
            // Handle basic filters (name, description, category, brand)
            $sql = "SELECT * FROM products WHERE LOWER($filter) LIKE ?";
            break;
        case 'date_added':
            // Filter by exact date (date added)
            $sql = "SELECT * FROM products WHERE DATE(date_added) = ?";
            break;
        case 'date_day':
            // Filter by day (extract day from date_added)
            $sql = "SELECT * FROM products WHERE DAY(date_added) = ?";
            break;
        case 'date_month':
            // Filter by month (extract month from date_added)
            $sql = "SELECT * FROM products WHERE MONTH(date_added) = ?";
            break;
        case 'date_year':
            // Filter by year (extract year from date_added)
            $sql = "SELECT * FROM products WHERE YEAR(date_added) = ?";
            break;
        default:
            // Invalid filter (handle appropriately)
            $response['error'] = "Invalid filter specified.";
            echo json_encode($response);
            exit;
    }

    // Prepare and execute the SQL query with search term
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $searchTerm = '%' . strtolower($search) . '%';
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        
        // Get result set from the prepared statement
        $result = $stmt->get_result();

        // Iterate through each row of the result set and store product details in the response array
        while ($row = $result->fetch_assoc()) {
            $product = array(
                'name' => $row['name'],
                'category' => $row['category'],
                'brand' => $row['brand'],
                'unit' => $row['unit'],
                'cost_per_unit' => $row['cost_per_unit'],
                'description' => $row['description'],
                'stock' => $row['stock'],
                'date_added' => $row['date_added']
            );
            array_push($response['products'], $product);
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Error handling if the prepared statement fails
        $response['error'] = "Error preparing SQL statement: " . $conn->error;
    }
} else {
    // Error handling for missing search item or filter
    $response['error'] = "Missing search item or filter parameters.";
}

// Close the database connection
$conn->close();

// Encode the response array as JSON and output the result
echo json_encode($response);
?>
