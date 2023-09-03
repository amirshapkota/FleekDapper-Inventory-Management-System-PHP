<?php
$servername = "localhost";
$username = "root";
$password = "";
$databaseName = "fleekdapper_ims";

$conn = mysqli_connect($servername, $username, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "CREATE DATABASE IF NOT EXISTS $databaseName";
if (!mysqli_query($conn, $sql)) {
    echo "Error creating database: " . mysqli_error($conn);
}

$conn = mysqli_connect($servername, $username, $password, $databaseName);

$sql = "CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoryName VARCHAR(255) NOT NULL,
    categoryType VARCHAR(255) NOT NULL
);";

if (!mysqli_query($conn, $sql)) {
    echo "Error: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(255) NOT NULL,
    productName VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    size VARCHAR(255)
);";

if (!mysqli_query($conn, $sql)) {
    echo "Error: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    status VARCHAR(255) NOT NULL
);";

if (!mysqli_query($conn, $sql)) {
    echo "Error: " . mysqli_error($conn);
}
