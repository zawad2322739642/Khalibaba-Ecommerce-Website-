<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/engine.php';
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
$payload = json_decode(file_get_contents('php://input'), true);
$query = trim((string)($payload['query'] ?? $_POST['query'] ?? ''));
if ($query === '' || (function_exists('mb_strlen') ? mb_strlen($query) : strlen($query)) > 300) { http_response_code(422); echo json_encode(['error' => 'Enter a question or product request between 1 and 300 characters.']); exit; }
$products = [];
$result = $conn->query('SELECT id, name, category, description, price, stock, image FROM products ORDER BY created_at DESC');
while ($row = $result->fetch_assoc()) $products[] = $row;
$orderCount = null; $userId = null;
if (isset($_SESSION['user'])) {
    $userId = (int)$_SESSION['user']['id'];
    if ($_SESSION['user']['role'] === 'buyer') { $stmt = $conn->prepare('SELECT COUNT(*) AS total FROM orders WHERE buyer_id = ?'); $stmt->bind_param('i', $userId); $stmt->execute(); $orderCount = (int)$stmt->get_result()->fetch_assoc()['total']; }
}
$answer = aiBuildResponse($query, $products, $orderCount);
$stmt = $conn->prepare('INSERT INTO ai_interactions (user_id, query_text, intent, confidence) VALUES (?, ?, ?, ?)');
if ($stmt) {
    $intent = $answer['intent'];
    $confidence = $answer['confidence'];
    $stmt->bind_param('isss', $userId, $query, $intent, $confidence);
    $stmt->execute();
}
echo json_encode($answer, JSON_UNESCAPED_UNICODE);
