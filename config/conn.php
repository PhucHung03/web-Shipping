<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$db_name = 'quanly_giaohang';
$username = 'root';
$password = '';

try {
    $conn = new mysqli($host, $username, $password, $db_name);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    // Set charset to utf8mb4
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}

return $conn;
?> 