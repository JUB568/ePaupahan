<?php
$servername = "localhost";
$username = "root"; 
$password = "";    
$dbname = "testing";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
} else {
    error_log("Database connection successful.");
}
?>
