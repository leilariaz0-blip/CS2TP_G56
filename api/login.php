<?php
// show errors while testing
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';
header('Content-Type: application/json');

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

$username = $data['username'] ?? null;
$password = $data['password'] ?? null;

if (!$username || !$password) {
    echo json_encode([
        'success' => false,
        'error'   => 'Username and password required'
    ]);
    exit;
}

// find user by username OR email
$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? OR email = ?");
if (!$stmt) {
    echo json_encode([
        'success' => false,
        'error'   => 'Database error (prepare)'
    ]);
    exit;
}

$stmt->bind_param("ss", $username, $username);
$stmt->execute();
$result = $stmt->get_result();
$user   = $result->fetch_assoc();

// SIMPLE check: plain text compare (for now)
// make sure your DB `users.password` column has plain text passwords
if ($user && $password === $user['password']) {
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['username']  = $user['username'];

    // optional: move guest cart to this user
    $sessionId    = session_id();
    $transferStmt = $conn->prepare("UPDATE cart SET user_id = ?, session_id = NULL WHERE session_id = ?");
    if ($transferStmt) {
        $transferStmt->bind_param("is", $user['id'], $sessionId);
        $transferStmt->execute();
        $transferStmt->close();
    }

    echo json_encode([
        'success'  => true,
        'username' => $user['username']
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error'   => 'Invalid credentials'
    ]);
}

$stmt->close();
$conn->close();
