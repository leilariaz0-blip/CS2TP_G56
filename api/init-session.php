<?php
// Start session FIRST before any headers
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');
// Allow credentials with CORS
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Credentials: true');
}
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

echo json_encode([
    'success' => true,
    'sessionId' => session_id(),
    'cartCount' => array_sum(array_map(function($item) { return $item['quantity']; }, $_SESSION['cart'] ?? []))
]);
?>
