<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <link rel="stylesheet" href="forms_header.css">
    <nav>
        <div>
           
        </div>
    </nav>
<body>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #ecf0f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #423c89;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input, button {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
            margin-bottom: 20px;
        }
        button {
            background-color: #3498db;
            color: #ffffff;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Delete Product</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="product_id">Enter Product ID to Delete:</label>
            <input type="number" id="product_id" name="product_id" required>
            <button type="submit" name="delete">Delete Product</button>
        </form>

        <?php
        // Check if the form was submitted and the delete button was clicked
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
            // Include database connection file
            require_once 'db.php';

            // Retrieve selected product ID from the form
            $product_id = $_POST['product_id'];

            // Prepare SQL statement to delete the product
            $delete_sql = "DELETE FROM products WHERE id = ?";
            $stmt = $conn->prepare($delete_sql);

            if ($stmt) {
                // Bind parameter and execute the deletion
                $stmt->bind_param("i", $product_id);
                
                if ($stmt->execute()) {
                    // Product deleted successfully
                    echo "<p style='color: green;'>Product with ID $product_id deleted successfully!</p>";
                } else {
                    // Error deleting product
                    echo "<p style='color: red;'>Error deleting product: " . $stmt->error . "</p>";
                }

                $stmt->close(); // Close prepared statement
            } else {
                // Error preparing delete statement
                echo "<p style='color: red;'>Error preparing delete statement: " . $conn->error . "</p>";
            }

            // Close the database connection
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
