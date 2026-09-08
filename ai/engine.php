<?php
/** Lightweight, transparent AI helpers for supported shopping tasks. */
function aiNormalizeText($value) {
    $value = strtolower(trim((string)$value));
    $value = preg_replace('/[^a-z0-9\s-]/', ' ', $value);
    return preg_replace('/\s+/', ' ', $value);
}

function aiTokens($query) {
    $synonyms = ['phone' => ['charger', 'cable', 'wireless'], 'charging' => ['charger', 'cable', 'usb-c'], 'charge' => ['charger', 'cable'], 'laptop' => ['stand', 'hub', 'usb-c'], 'computer' => ['mouse', 'hub', 'stand'], 'audio' => ['earbuds'], 'headphone' => ['earbuds']];
    $tokens = array_values(array_filter(explode(' ', aiNormalizeText($query)), function ($token) { return strlen($token) > 1; }));
    foreach ($tokens as $token) if (isset($synonyms[$token])) $tokens = array_merge($tokens, $synonyms[$token]);
    return array_values(array_unique($tokens));
}

function aiRankProducts($products, $query) {
    $tokens = aiTokens($query); $ranked = [];
    foreach ($products as $product) {
        $name = aiNormalizeText($product['name']); $category = aiNormalizeText($product['category']); $description = aiNormalizeText($product['description']); $score = 0; $matched = [];
        foreach ($tokens as $token) {
            if (strpos($name, $token) !== false) { $score += 6; $matched[] = $token; }
            if (strpos($category, $token) !== false) { $score += 4; $matched[] = $token; }
            if (strpos($description, $token) !== false) { $score += 2; $matched[] = $token; }
        }
        if ($score > 0) { $product['ai_score'] = $score; $product['ai_matches'] = array_values(array_unique($matched)); $ranked[] = $product; }
    }
    usort($ranked, function ($a, $b) { return $b['ai_score'] <=> $a['ai_score'] ?: $b['stock'] <=> $a['stock']; });
    return array_slice($ranked, 0, 4);
}

function aiClassifyIntent($query) {
    $text = aiNormalizeText($query);
    if (preg_match('/\b(order|delivery|track|shipping|shipped)\b/', $text)) return 'order';
    if (preg_match('/\b(return|refund|cancel)\b/', $text)) return 'policy';
    if (preg_match('/\b(hello|hi|help|support)\b/', $text)) return 'support';
    return 'product_search';
}

function aiBuildResponse($query, $products, $orderCount = null) {
    $intent = aiClassifyIntent($query);
    if ($intent === 'order') {
        if ($orderCount === null) return ['intent' => $intent, 'confidence' => 'medium', 'message' => 'Please sign in to view order details. You can track orders from your Buyer Dashboard.', 'products' => []];
        return ['intent' => $intent, 'confidence' => 'high', 'message' => $orderCount ? "You have {$orderCount} order(s). Open your Buyer Dashboard to see their latest status." : 'You do not have any orders yet. I can help you find a product to get started.', 'products' => []];
    }
    if ($intent === 'policy') return ['intent' => $intent, 'confidence' => 'medium', 'message' => 'For returns, refunds, or cancellations, please contact Khalibaba support with your order number. A seller can only process an order according to its current status.', 'products' => []];
    if ($intent === 'support') return ['intent' => $intent, 'confidence' => 'high', 'message' => 'I can help find technology accessories, explain available stock, or point you to your order status. Try: “I need a fast charger for my phone.”', 'products' => []];
    $ranked = aiRankProducts($products, $query);
    if (!$ranked) return ['intent' => 'fallback_search', 'confidence' => 'low', 'message' => 'I was not confident about a product match, so I switched to standard search. Try a product type such as charger, cable, earbuds, mouse, hub, or stand.', 'products' => []];
    $available = array_filter($ranked, function ($product) { return (int)$product['stock'] > 0; });
    return ['intent' => 'product_search', 'confidence' => 'high', 'message' => $available ? 'Here are the strongest catalog matches for your request.' : 'These are the closest catalog matches, but they are currently out of stock.', 'products' => $ranked];
}
