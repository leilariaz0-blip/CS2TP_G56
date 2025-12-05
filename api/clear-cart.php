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

// Clear the cart
$_SESSION['cart'] = [];

echo json_encode([
    'success' => true,
    'message' => 'Cart cleared',
    'cartCount' => 0,
    'cartTotal' => 0
]);
?>
