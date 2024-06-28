<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Supplier</title>
    <link rel="stylesheet" href="forms_header.css">
    <nav>
        <div>
           
        </div>
    </nav>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 10px;
            color: #333;
        }
        input[type="text"], input[type="submit"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Delete Supplier</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="delete-form">
        <label for="supplierName">Supplier Name:</label>
        <input type="text" id="supplierName" name="supplierName" required>
        <input type="submit" value="Delete Supplier" name="delete">
    </form>

    <?php
    // Include database connection file
    require_once 'db.php';

    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
        // Retrieve supplier name from the form
        $supplierName = $_POST['supplierName'];

        // Prepare SQL statement to delete the supplier
        $delete_sql = "DELETE FROM suppliers WHERE name = ?";
        $stmt = $conn->prepare($delete_sql);

        if ($stmt) {
            // Bind parameter and execute the deletion
            $stmt->bind_param("s", $supplierName);
            
            if ($stmt->execute()) {
                // Supplier deleted successfully
                echo "<script>alert('Supplier deleted successfully.');</script>";
                echo "<script>window.location = 'delete_supplier.php';</script>";
                exit(); // Terminate script execution after redirection
            } else {
                echo "Error deleting supplier: " . $stmt->error;
            }

            $stmt->close(); // Close prepared statement
        } else {
            echo "Error preparing delete statement: " . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
    ?>

</div>

</body>
</html>
