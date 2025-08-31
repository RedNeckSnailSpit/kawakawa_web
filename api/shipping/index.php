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
    
    $from = $_GET['from'] ?? '';
    $to = $_GET['to'] ?? '';
    
    if (empty($from) || empty($to)) {
        throw new Exception('Both from and to locations are required');
    }
    
    // Look up shipping cost for the route
    $stmt = $pdo->prepare("
        SELECT cost, created_at, updated_at 
        FROM shipping 
        WHERE from_location = ? AND to_location = ?
        ORDER BY updated_at DESC 
        LIMIT 1
    ");
    $stmt->execute([$from, $to]);
    $shipping = $stmt->fetch();
    
    if ($shipping) {
        echo json_encode([
            'success' => true,
            'from_location' => $from,
            'to_location' => $to,
            'cost' => (float)$shipping['cost'],
            'last_updated' => $shipping['updated_at']
        ]);
    } else {
        // No shipping route found, return 0 cost
        echo json_encode([
            'success' => true,
            'from_location' => $from,
            'to_location' => $to,
            'cost' => 0.0,
            'last_updated' => null,
            'message' => 'No shipping route data available'
        ]);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to fetch shipping cost',
        'message' => $e->getMessage()
    ]);
}
?>