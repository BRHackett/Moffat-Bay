<?php
$servername = "localhost";
$username = "admin";  // Default MySQL username in XAMPP is 'root'
$password = "pass";      // Default password for root in XAMPP is empty
$database = "moffatbay"; // Replace with your database name if necessary

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully to the database!";
?>
