<?php
require_once 'db.php';

session_start();

// Check if the user is logged in, redirect to login if not
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

// Fetch suppliers from the database
$sql = "SELECT * FROM suppliers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: white;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd
          
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .table-container {
            width: 80%;
            margin: auto;
        }
        h2{
            color: white;
            font-size:30px;
        }
    </style>
    <div class='table-container'>
        <table>   <h2>View Suppliers</h2>
            <thead>
                <tr>
                    <th>Supplier ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile No.</th>
                    <th>Address</th>
                    <th>Details</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
    ";

    while ($row = $result->fetch_assoc()) {
        echo "
        <tr>
            <td>" . htmlspecialchars($row['id']) . "</td>
            <td>" . htmlspecialchars($row['name']) . "</td>
            <td>" . htmlspecialchars($row['email']) . "</td>
            <td>" . htmlspecialchars($row['mobile']) . "</td>
            <td>" . htmlspecialchars($row['address']) . "</td>
            <td>" . htmlspecialchars($row['details']) . "</td>
            <td>" . htmlspecialchars($row['remarks']) . "</td>
        </tr>
        ";
    }

    echo "
            </tbody>
        </table>
    </div>
    ";
} else {
    echo "<div style='text-align: center; margin-top: 20px;'>No suppliers found.</div>";
}

$conn->close();
?>
