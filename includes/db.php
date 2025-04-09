<?php
$host = "localhost";
$user = "root";
$pass = "Prath@0524"; 
$dbname = "ip_facilitation";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
