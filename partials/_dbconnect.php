<?php
// Connecting to databse
$servername = "localhost";
$username = "root";
$password = "";
$database = "idiscuss";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Sorry!We cannot connect due to: " . mysqli_connect_error());
} 
