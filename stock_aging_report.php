<?php
// Include database connection file (assuming 'db.php' contains your database connection code)
require_once '../db.php';

// Initialize an array to store stock aging data
$stockAging = array();

// Fetch product data with date added from the database
$sql = "SELECT id, name, stock, date_added FROM products";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Loop through each row in the result set
    while ($row = $result->fetch_assoc()) {
        // Calculate the age of the product in days
        $dateAdded = strtotime($row['date_added']);
        $currentDate = strtotime(date('Y-m-d')); // Current date
        $daysInStock = floor(($currentDate - $dateAdded) / (60 * 60 * 24));

        // Determine the stock aging classification (new vs. old)
        $stockStatus = ($daysInStock > 30) ? 'Old' : 'New';

        // Build an associative array for each product's stock aging
        $agingInfo = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'stock' => $row['stock'],
            'date_added' => $row['date_added'],
            'stock_status' => $stockStatus
        );

        // Push the stock aging details into the stockAging array
        $stockAging[] = $agingInfo;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Aging Report</title>
    <link rel="stylesheet" href="report_header.css">
    <style>
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
            color: #3498db;
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
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
   
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
       
        .new-stock {
            color: green;
        }
        .old-stock {
            color: red;
        }
    </style>
</head>
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
<body>

    <div class="container">
        <h1>Stock Aging Report</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Stock</th>
                    <th>Date Added</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stockAging as $item): ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['stock']; ?></td>
                        <td><?php echo $item['date_added']; ?></td>
                        <td class="<?php echo ($item['stock_status'] === 'New') ? 'new-stock' : 'old-stock'; ?>"><?php echo $item['stock_status']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <footer>
            Generated on <?php echo date('Y-m-d H:i:s'); ?>
        </footer>
    </div>

    <script>
        function printReport() {
            window.print();
        }
    </script>
</body>


</html>
