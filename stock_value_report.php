<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Value Report</title>
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
        <?php
        // Include database connection file
        require_once '../db.php';

        // SQL query to fetch stock value report data
        $sql = "SELECT id, name, stock, cost_per_unit, (stock * cost_per_unit) AS total_value FROM products";
        $result = $conn->query($sql);

        // Check if query executed successfully
        if ($result && $result->num_rows > 0) {
            // Display the table headers
            echo "
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Stock</th>
                        <th>Cost Per Unit</th>
                        <th>Total Value</th>
                    </tr>
                </thead>
                <tbody>";

            // Fetch data from the result set and display rows in the table
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['stock']}</td>
                        <td>{$row['cost_per_unit']}</td>
                        <td>{$row['total_value']}</td>
                    </tr>";
            }

            // Close the table body and table tags
            echo "
                </tbody>
            </table>";
        } else {
            // Handle case where no data is found
            echo "No data found for stock value report.";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
<script>
     function printReport() {
            window.print();
        }
</script>
<style>

/* Style the table */
table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
}

table th, table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    
}
th{
    background-color: white;
}
/* Alternate row colors */
tbody tr:nth-child(even) {
    background-color: #f2f2f2; /* Light gray */
}

tbody tr:nth-child(odd) {
    background-color: #ffffff; /* White */
}
</style>
