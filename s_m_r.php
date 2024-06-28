<?php
// Include database connection file
require_once '../db.php';

// Fetch stock movements data including product details
$sql = "SELECT sm.id, sm.product_id, p.name AS product_name, sm.stock_change AS stock_change, sm.action, sm.date_modified
        FROM stock_movements sm
        JOIN products p ON sm.product_id = p.id
        ORDER BY sm.date_modified DESC";

$result = $conn->query($sql);

// Check if query executed successfully
if ($result && $result->num_rows > 0) {
    $stockMovements = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $stockMovements = array(); // No data found
}

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
    <header>
        <nav>
            <div class="logo">ABC Inventory System</div>
            <ul class="nav-links">
            <li><a href="inventory_report.php">Inventory Reports</a></li>
                <li><a href="stock_aging_report.php">Stock Aging Reports</a></li>
                <li><a href="stock_movement_report.html">Stock Movement Reports</a></li>
                <li><a href="stock_value_report.php">Stock Value Reports</a></li>
                <button class="print-button" onclick="printReport()">Print Report</button>
                
            </ul>
        </nav>
    </header>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            background-color: white;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
            background-color: white;
        }
    </style>
</head>
<body>
    <h2>Stock Movement Report</h2>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity Change</th>
                <th>Movement Type</th>
                <th>Movement Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stockMovements as $movement): ?>
                <tr>
                    <td><?php echo $movement['product_name']; ?></td>
                    <td><?php echo $movement['stock_change']; ?></td>
                    <td><?php echo ucfirst($movement['action']); ?></td>
                    <td><?php echo $movement['date_modified']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
