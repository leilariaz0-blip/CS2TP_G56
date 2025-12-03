<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "jewelry-store";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
?>
