<?php
// CONFIG - COPY/RENAME TO config.php AND ALTER BELOW SETTINGS

// config.php - Configuration settings

// Database connection details
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'kawakawa');

// Organization information
$org_info = [
    'name' => 'Kawakawa Inc.',
    'description' => 'A tight-knit Prosperous Universe corporation focused on resource coordination and community building.',
    'links' => [
        [
            'title' => 'Discord Server',
            'url' => 'https://discord.gg/1234567890',
            'type' => 'discord'
        ]
    ]
];

$related_orgs = [
    [
        'name' => 'Related Org',
        'description' => 'A related Org',
        'links' => [
            [
                'title' => 'Discord Server',
                'url' => 'https://discord.gg/1234567890',
                'type' => 'discord'
            ]
        ]
    ]
];

// Credits information
$credits = [
    [
        'user' => 'RedNeckSnailSpit',
        'contribution' => 'Website Development & Database Design',
        'links' => [
            ['title' => 'GitHub', 'url' => 'https://github.com/RedNeckSnailSpit', 'type' => 'github']
        ]
    ]
];

// Related tools
$tools = [
    ['title' => 'PrUn Planner', 'url' => 'https://prunplanner.org'],
    ['title' => 'FIO', 'url' => 'https://fio.fnar.net']
];

// Open source links
$open_source = [
    [
        'title' => 'Kawakawa Corp Website',
        'description' => 'This website\'s source code',
        'url' => 'https://github.com/RedNeckSnailSpit/kawakawa_web'
    ],
    [
        'title' => 'Backend Services',
        'description' => 'Data collection scripts',
        'url' => 'https://github.com/RedNeckSnailSpit/kawakawa_services'
    ]
];

// Database connection function
function getDBConnection() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE,
            DB_USERNAME,
            DB_PASSWORD,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
        return $pdo;
    } catch (PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        return null;
    }
}
?>