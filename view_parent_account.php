<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Management - View Parent Accounts</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ecf0f5;
            background-image: url('images/con7.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
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

        main {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        footer {
    background-color: #423c89;
    color: white;
    padding: 20px;
    text-align: center;
    position: relative;
    width: 100%;
    bottom: 0;
}
    </style>

    <header>
        <nav>
            <div class="logo">Warehouse Inventory System</div>
            <ul class="nav-links">
                <li><a href="../dashboard.html">Home</a></li>
                <li><a href="../about.html">About</a></li>
                <li><a href="../contactus.html">Contact</a></li>
                <li><a href="../add_product.html">Product</a></li>
                <li><a href="../view_product.html">Reports</a></li>
                <li><a href="parent_account.html">Parent Accounts</a></li>
                <li><a href="control_account.html">Control Accounts</a></li>
                <li><a href="ledger_account.html">Ledger Accounts</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>View ALL Parent Accounts</h2>

        <table id="parentAccountTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Account Name</th>
                    <th>Initial Amount</th>
                </tr>
            </thead>
            <tbody id="parentAccountTableBody">
                <?php
                // Database connection (replace with your database credentials)
              require_once('../db.php');

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch data from parent_accounts table
                $sql = "SELECT id, account_name, initial_amount FROM parent_accounts";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['account_name'] . "</td>";
                        echo "<td>" . $row['initial_amount'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No parent accounts found</td></tr>";
                }

                // Close database connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>Contact us at: your.email@example.com</p>
        <p>&copy; 2024 ABC Inventory System. All rights reserved.</p>
    </footer>
</body>
</html>
