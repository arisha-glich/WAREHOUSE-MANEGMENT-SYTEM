<?php
require_once 'db.php';

if ($conn) {
    echo "Connected successfully!";
} else {
    echo "Connection failed!";
}

$conn->close();
?>
