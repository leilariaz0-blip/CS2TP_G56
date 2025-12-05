<?php
session_start();

// LOCAL MySQL settings (XAMPP / WAMP typical)
$servername = "localhost";
$username   = "root";          // 👈 default local user
$password   = "";              // 👈 empty password
$database   = "cs2team56_db";  // make sure this database exists

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode([
        'success' => false,
        'error'   => 'Database connection failed: ' . $conn->connect_error
    ]));
}
