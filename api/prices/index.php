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
    
    // First, try to get the specific price for the location
    $stmt = $pdo->prepare("
        SELECT p.price, p.last_updated 
        FROM prices p 
        WHERE p.ticker = ? AND p.location = ?
        ORDER BY p.last_updated DESC 
        LIMIT 1
    ");
    $stmt->execute([$ticker, $location]);
    $price = $stmt->fetch();
    
    if (!$price) {
        // If no price found for the specific location, try to get default price
        $stmt = $pdo->prepare("
            SELECT p.price, p.last_updated, p.location
            FROM prices p 
            WHERE p.ticker = ? AND p.is_default = 1
            ORDER BY p.last_updated DESC 
            LIMIT 1
        ");
        $stmt->execute([$ticker]);
        $price = $stmt->fetch();
        
        if (!$price) {
            // If still no price found, try Proxion as fallback
            $stmt = $pdo->prepare("
                SELECT p.price, p.last_updated, p.location
                FROM prices p 
                WHERE p.ticker = ? AND p.location = 'Proxion'
                ORDER BY p.last_updated DESC 
                LIMIT 1
            ");
            $stmt->execute([$ticker]);
            $price = $stmt->fetch();
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
            'source_location' => $price['location'] ?? $location
        ]);
    } else {
        // No price found, return 0
        echo json_encode([
            'success' => true,
            'ticker' => $ticker,
            'item_name' => $item ? $item['name'] : $ticker,
            'category' => $item ? $item['category'] : null,
            'location' => $location,
            'price' => 0.0,
            'last_updated' => null,
            'source_location' => $location,
            'message' => 'No price data available'
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