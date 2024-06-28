<!-- HTML content for admin panel -->
<h1>User Management - Admin Panel</h1>

<!-- Display user list -->
<ul>
    <?php while ($row = $result->fetch_assoc()): ?>
        <li><?php echo $row['username']; ?></li>
    <?php endwhile; ?>
</ul>


<?php
session_start();

// Check if the user is authenticated as admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.html");
    exit();
}

// Include database connection
require_once 'db.php';

// Retrieve user list from database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>


