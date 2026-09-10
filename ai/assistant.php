<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/engine.php';
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
$payload = json_decode(file_get_contents('php://input'), true);
$query = trim((string)($payload['query'] ?? $_POST['query'] ?? ''));
if ($query === '' || (function_exists('mb_strlen') ? mb_strlen($query) : strlen($query)) > 300) { http_response_code(422); echo json_encode(['error' => 'Enter a question or product request between 1 and 300 characters.']); exit; }
$products = [];
$result = $conn->query("SELECT p.id,p.name,p.category,p.brand,p.description,p.specifications,p.price,p.stock,p.image FROM products p JOIN users u ON u.id=p.seller_id WHERE p.status='Approved' AND u.seller_status='Approved' ORDER BY p.created_at DESC");
while ($row = $result->fetch_assoc()) $products[] = $row;
$orders = []; $userId = null;
if (isset($_SESSION['user'])) {
    $userId = (int)$_SESSION['user']['id'];
    if ($_SESSION['user']['role'] === 'buyer') { $stmt = $conn->prepare('SELECT id,status,created_at FROM orders WHERE buyer_id=? ORDER BY created_at DESC'); $stmt->bind_param('i', $userId); $stmt->execute(); $orderResult=$stmt->get_result(); while($order=$orderResult->fetch_assoc()) $orders[]=$order; }
}
$answer = aiBuildResponse($query, $products, $orders);
if (!empty($answer['fallback_query'])) $answer['fallback_url']='/Khalibaba/index.php?q='.rawurlencode($answer['fallback_query']);
$stmt = $conn->prepare('INSERT INTO ai_interactions (user_id, query_text, intent, confidence) VALUES (?, ?, ?, ?)');
if ($stmt) {
    $intent = $answer['intent'];
    $confidence = $answer['confidence'];
    $stmt->bind_param('isss', $userId, $query, $intent, $confidence);
    $stmt->execute();
}
echo json_encode($answer, JSON_UNESCAPED_UNICODE);
