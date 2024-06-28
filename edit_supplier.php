<!-- edit_supplier.php -->
<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $supplierId = $_GET['id'];

    // Fetch the supplier details based on the supplied ID
    $sql = "SELECT * FROM suppliers WHERE supplier_id = '$supplierId'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Display the edit form (you can customize this form based on your requirements)
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Supplier</title>
            <link rel="stylesheet" href="styles.css">
        </head>
        <body>
            <h2>Edit Supplier</h2>
            <form action="update_supplier.php" method="post">
                <input type="hidden" name="supplierId" value="<?php echo $row['supplier_id']; ?>">
                <!-- Display other fields for editing -->
                <label for="supplierName">Name:</label>
                <input type="text" id="supplierName" name="supplierName" value="<?php echo $row['name']; ?>" required>

                <!-- Include other fields as needed -->

                <input type="submit" value="Update Supplier">
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Supplier not found.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
