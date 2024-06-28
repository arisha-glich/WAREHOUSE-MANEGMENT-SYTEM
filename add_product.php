<?php
// Include database connection file (assuming 'db.php' contains your database connection code)
require_once 'db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $productName = $_POST["productName"];
    $unit = $_POST["unit"];
    $costPerUnit = $_POST["costPerUnit"];
    $description = $_POST["description"];
    $stock = $_POST["stock"];
    $dateAdded = $_POST["dateAdded"];
    $brand = $_POST["brand"];
    $category = $_POST["category"];
    $warehouseLocation = $_POST["warehouse_location"]; 


    // Start a transaction
    $conn->begin_transaction();

    // Prepare SQL statement to insert product details into the 'products' table
    $sqlInsertProduct = "INSERT INTO products (name, unit, cost_per_unit, description, stock, date_added, brand, category, warehouse_location) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtInsertProduct = $conn->prepare($sqlInsertProduct);

    if ($stmtInsertProduct) {
        // Bind parameters and execute the statement to insert product
        $stmtInsertProduct->bind_param("ssdssssss", $productName, $unit, $costPerUnit, $description, $stock, $dateAdded, $brand, $category, $warehouse_location); // Corrected variable name
        
        if ($stmtInsertProduct->execute()) {
            // Product added successfully
            // Retrieve the product ID of the newly inserted product
            $productId = $stmtInsertProduct->insert_id;

            // Define transaction details
            $transactionType = ($stock > 0) ? 'purchase' : 'sale'; // Determine transaction type based on stock value
            $quantity = abs($stock); // Number of units involved in the transaction
            $transactionDate = date('Y-m-d H:i:s'); // Current date and time

            // Prepare SQL statement to insert transaction into the 'transactions' table
            $sqlInsertTransaction = "INSERT INTO transactions (product_id, transaction_type, quantity, transaction_date, cost_per_unit) 
                                     VALUES (?, ?, ?, ?, ?)";
            $stmtInsertTransaction = $conn->prepare($sqlInsertTransaction);

            if ($stmtInsertTransaction) {
                // Bind parameters and execute the statement to insert transaction
                $stmtInsertTransaction->bind_param("isids", $productId, $transactionType, $quantity, $transactionDate, $costPerUnit);
                
                if ($stmtInsertTransaction->execute()) {
                    // Transaction recorded successfully
                    $conn->commit(); // Commit the transaction
                    header("location: add_product.html");
                } else {
                    // Error executing the transaction insert statement
                    echo "Error recording transaction: " . $stmtInsertTransaction->error;
                    $conn->rollback(); // Rollback the transaction
                }
                
                // Close the prepared statement for transaction
                $stmtInsertTransaction->close();
            } else {
                // Error preparing the transaction insert statement
                echo "Error preparing transaction statement: " . $conn->error;
                $conn->rollback(); // Rollback the transaction
            }
        } else {
            // Error executing the product insert statement
            echo "Error adding product: " . $stmtInsertProduct->error;
            $conn->rollback(); // Rollback the transaction
        }
        
        // Close the prepared statement for product
        $stmtInsertProduct->close();
    } else {
        // Error preparing the product insert statement
        echo "Error preparing product statement: " . $conn->error;
        $conn->rollback(); // Rollback the transaction
    }
} else {
    // Invalid request method
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
