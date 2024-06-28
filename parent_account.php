<?php
// Database connection (replace with your database credentials)
require_once('../db.php');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission to create new parent account
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_name = $_POST['account_name'];
    $initial_amount = $_POST['initial_amount'];

    // Insert new parent account into the database
    $sql = "INSERT INTO parent_accounts (account_name, initial_amount) VALUES ('$account_name', $initial_amount)";

    if ($conn->query($sql) === TRUE) {
        // Retrieve the details of the newly added parent account
        $newAccountId = $conn->insert_id; // Get the ID of the newly inserted parent account

        $sql_new_account = "SELECT id, account_name, initial_amount FROM parent_accounts WHERE id = $newAccountId";
        $result_new_account = $conn->query($sql_new_account);

        if ($result_new_account->num_rows > 0) {
            $row = $result_new_account->fetch_assoc();
            $newParentAccount = array(
                'id' => $row['id'],
                'account_name' => $row['account_name'],
                'initial_amount' => $row['initial_amount']
            );

            // Close database connection
            $conn->close();

            // Return the details of the newly added parent account as JSON response
            header('Content-Type: application/json');
            echo json_encode($newParentAccount);
            exit; // Stop further script execution
        }
    } else {
        echo "Error creating parent account: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>
