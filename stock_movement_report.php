<?php
// Include database connection file
require_once '../db.php';

// Function to fetch stock movements report
function fetchStockMovementsReport($conn) {
    // SQL query to fetch stock movements report
    $sql = "SELECT sm.id, sm.product_id, p.name AS product_name, sm.stock_change AS stock_change, sm.action, sm.date_modified
            FROM stock_movement sm
            JOIN products p ON sm.product_id = p.id
            ORDER BY sm.date_modified DESC";

    // Execute the query
    $result = $conn->query($sql);

    // Check if the query executed successfully
    if ($result && $result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC); // Return the fetched data
    } else {
        return array(); // Return an empty array if no data found
    }
}

// Validate product ID existence
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['product_id'], $_POST['stock_change'], $_POST['action'])) {
        $productId = $_POST['product_id'];
        $stockChange = $_POST['stock_change'];
        $action = $_POST['action'];

        // Check if product ID exists in the database
        $checkSql = "SELECT * FROM products WHERE id = ?";
        $stmt = $conn->prepare($checkSql);
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        // If product ID is not found, display an error message and exit
        if ($result->num_rows == 0) {
            die('Invalid Product ID. Please enter a valid Product ID.');
        }

        // Validate stock_change input (should be a numeric value)
        if (!is_numeric($stockChange)) {
            die('Invalid Stock Change value. Please enter a valid numeric value.');
        }

        // Perform insertion into stock_movements table
        $insertSql = "INSERT INTO stock_movement (product_id, stock_change, action, date_modified) 
                      VALUES (?, ?, ?, NOW())";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param('iis', $productId, $stockChange, $action);

        if ($insertStmt->execute()) {
            // Fetch updated stock movements report
            $stockMovements = fetchStockMovementsReport($conn);
        } else {
            die('Error: Stock movement insertion failed.');
        }
    } else {
        die('Missing required form data.');
    }
}

// Fetch initial stock movements report
$stockMovements = fetchStockMovementsReport($conn);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Movement Report</title>
    <link rel="stylesheet" href="report_header.css">
    
    <style>
     body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            height: 80vh; /* Full viewport height */
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid white;
            padding: 12px;
            text-align: left;
            background-color: white;
        }
        th {
            background-color: wheat;
            color: #333;
            ;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">ABC Inventory System</div>
        <nav>
            <ul class="nav-links">
                <li><a href="inventory_report.php">Inventory Reports</a></li>
                <li><a href="stock_aging_report.php">Stock Aging Reports</a></li>
                <li><a href="stock_movement_report.html">Stock Movement Reports</a></li>
                <li><a href="stock_value_report.php">Stock Value Reports</a></li>
                <button class="print-button" onclick="printReport()">Print Report</button>
            </ul>
        </nav>
    </header>

   
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity Change</th>
                <th>Movement Date</th>
            </tr>
        </thead>
        <tbody>  
            <?php foreach ($stockMovements as $movement): ?>
                <tr>
                    <td><?php echo $movement['product_name']; ?></td>
                    <td><?php echo $movement['stock_change']; ?></td>
                    <td><?php echo $movement['date_modified']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
