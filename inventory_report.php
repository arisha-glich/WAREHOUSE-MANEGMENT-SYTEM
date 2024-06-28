<?php
// Include database connection file (assuming 'db.php' contains your database connection code)
require_once '../db.php';

// Initialize an array to store product data
$products = array();

// Fetch product data from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Loop through each row in the result set
    while ($row = $result->fetch_assoc()) {
        // Build an associative array for each product
        $product = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'cost_per_unit' => $row['cost_per_unit'],
            'description' => $row['description'],
            'brand' => $row['brand'],
            'category' => $row['category'],
            'stock' => $row['stock'],
        );

        // Push the product details into the products array
        $products[] = $product;
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
    <title>Inventory Report</title>
    <style>
        header img {
            size:20px;
    border-radius: 10%; /* Rounded border */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Soft shadow */
}


body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ecf0f5;
        }

        header {
            background-color: #423c89;
            color: #ffffff;
            padding: 15px 0;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            font-size: 1.5em;
            font-weight: bold;
        }

        .nav-links {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        .nav-links li {
            margin-right: 20px;
        }

        .nav-links a {
            text-decoration: none;
            color: #ffffff;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        header img {
            max-width: 150px;
            height: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid grey;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: grey;
            color: white;
        }
        footer {
            text-align: center;
            font-size: 14px;
            color: blue;
            margin-top: 20px;
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
        <header>
            <img src="../images/con_4.jpg" alt="Company Logo">
            <h1 style="color: blue;">Inventory Report</h1>
        </header>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Cost Per Unit</th>
                    <th>Description</th>
                    <th>Stock</th>
                    <th>Brand</th>
                    <th>Category</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['cost_per_unit']; ?></td>
                        <td><?php echo $product['description']; ?></td>
                        <td><?php echo $product['stock']; ?></td>
                        <td><?php echo $product['brand']; ?></td>
                        <td><?php echo $product['category']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <footer>
            Generated on <?php echo date('Y-m-d H:i:s'); ?>
        </footer>
        <script>
        function printReport() {
            window.print();
        }
    </script>
    </div>

</body>


</html>
