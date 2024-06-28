<?php
// Include database connection file
require_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $productId = $_POST['productId'];
    $transactionType = $_POST['transactionType'];
    $quantity = $_POST['quantity'];
    $costPerUnit = $_POST['costPerUnit'];
    $accountId = $_POST['account_id'];

    // Call the stored procedure based on the transaction type
    if ($transactionType == 'sale') {
        $sql = "CALL MakeSale(?, ?, ?)";
    } else {
        $sql = "CALL MakePurchase(?, ?, ?)";
    }

    // Prepare and bind
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iii", $productId, $quantity, $accountId);
        
        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the transaction table page
            header("Location: transaction.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        
        // Close the statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Retrieve transactions from the database
$sql = "SELECT * FROM transactions ORDER BY transaction_date DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Table</title>
    <link rel="stylesheet" href="../reports/report_header.css">
    <header>
    <nav>
        <div class="logo">Warehouse Inventory System</div>
        <ul class="nav-links">
                <li><a href="transaction.html">Home</a></li>
                <li><a href="../add_product.html">Product</a></li>
                <li><a href="../view_product.html">Reports</a></li>
            </ul>
    </nav>
</header>
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f0f0f0;
        }

        .no-transactions {
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Transaction Table</h2>
    <table>
        <thead>
        <tr>
            <th>Transaction ID</th>
            <th>Product ID</th>
            <th>Transaction Type</th>
            <th>Quantity</th>
            <th>Cost Per Unit</th>
            <th>Date</th>
            <th>Account ID</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Display transactions
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['product_id'] . "</td>";
                echo "<td>" . $row['transaction_type'] . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>$" . $row['cost_per_unit'] . "</td>";
                echo "<td>" . $row['transaction_date'] . "</td>";
                echo "<td>" . $row['account_id'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7' class='no-transactions'>No transactions found</td></tr>";
        }

        // Close database connection
        $conn->close();
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
