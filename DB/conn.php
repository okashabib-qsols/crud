<?php
$conn = mysqli_connect('192.168.10.4', 'admin', 'Admin!123', 'bootstrap_crud');
if ($conn->connect_error) {
    die('<div class="alert alert-danger" role="alert">Connection failed: ' . $conn->connect_error . '</div>');
}
?>