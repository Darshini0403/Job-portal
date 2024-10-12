<?php
$servername = "localhost:3307"; // Your database server
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "job portal"; // Your database name

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
