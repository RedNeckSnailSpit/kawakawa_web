<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../../src/config/config.php';

try {
    $pdo = getDBConnection();
    if (!$pdo) {
        throw new Exception('Database connection failed');
    }
    
    $ticker = $_GET['ticker'] ?? '';
    $location = $_GET['location'] ?? 'Proxion';
    
    if (empty($ticker)) {
        throw new Exception('Ticker is required');
    }
    
    $price = null;
    $source_location = $location;
    
    // First, try to get the specific price for the location
    $stmt = $pdo->prepare("
        SELECT p.price, p.last_updated, p.location
        FROM prices p 
        WHERE p.ticker = ? AND p.location = ?
        ORDER BY p.last_updated DESC 
        LIMIT 1
    ");
    $stmt->execute([$ticker, $location]);
    $price = $stmt->fetch();
    
    // If no price found for the specific location, fall back to Proxion
    if (!$price && $location !== 'Proxion') {
        $stmt = $pdo->prepare("
            SELECT p.price, p.last_updated, p.location
            FROM prices p 
            WHERE p.ticker = ? AND p.location = 'Proxion'
            ORDER BY p.last_updated DESC 
            LIMIT 1
        ");
        $stmt->execute([$ticker]);
        $price = $stmt->fetch();
        $source_location = 'Proxion';
    }
    
    // If still no price found, try any location with is_default flag
    if (!$price) {
        $stmt = $pdo->prepare("
            SELECT p.price, p.last_updated, p.location
            FROM prices p 
            WHERE p.ticker = ? AND p.is_default = 1
            ORDER BY p.last_updated DESC 
            LIMIT 1
        ");
        $stmt->execute([$ticker]);
        $price = $stmt->fetch();
        if ($price) {
            $source_location = $price['location'];
        }
    }
    
    // Get item details
    $stmt = $pdo->prepare("SELECT name, category FROM items WHERE ticker = ?");
    $stmt->execute([$ticker]);
    $item = $stmt->fetch();
    
    if ($price) {
        echo json_encode([
            'success' => true,
            'ticker' => $ticker,
            'item_name' => $item ? $item['name'] : $ticker,
            'category' => $item ? $item['category'] : null,
            'location' => $location,
            'price' => (float)$price['price'],
            'last_updated' => $price['last_updated'],
            'source_location' => $source_location,
            'fallback_used' => $source_location !== $location
        ]);
    } else {
        // No price found anywhere, return 0
        echo json_encode([
            'success' => true,
            'ticker' => $ticker,
            'item_name' => $item ? $item['name'] : $ticker,
            'category' => $item ? $item['category'] : null,
            'location' => $location,
            'price' => 0.0,
            'last_updated' => null,
            'source_location' => $location,
            'message' => 'No price data available for this item',
            'fallback_used' => false
        ]);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to fetch price',
        'message' => $e->getMessage()
    ]);
}
?>