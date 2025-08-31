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
    
    $search = $_GET['search'] ?? '';
    
    if (empty($search)) {
        // Return all locations if no search term
        $stmt = $pdo->prepare("SELECT name FROM locations ORDER BY name LIMIT 50");
        $stmt->execute();
    } else {
        // Search for locations matching the search term
        $searchTerm = '%' . $search . '%';
        $stmt = $pdo->prepare("SELECT name FROM locations WHERE name LIKE ? ORDER BY name LIMIT 20");
        $stmt->execute([$searchTerm]);
    }
    
    $locations = $stmt->fetchAll();
    
    // Transform to expected format
    $result = array_map(function($row) {
        return ['name' => $row['name']];
    }, $locations);
    
    echo json_encode([
        'success' => true,
        'locations' => $result
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to fetch locations',
        'message' => $e->getMessage()
    ]);
}
?>