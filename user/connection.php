<?php
$host = '127.0.0.1'; // Change to your database host
$username = 'root'; // Change to your database username
$password = ''; // Change to your database password
$dbname = 'virtualtryon'; // Change to your database name

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>
