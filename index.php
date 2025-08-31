<?php
// index.php - Main entry point and router
require_once 'src/config/config.php';

// Get the requested page from URL parameter or default to home
$page = $_GET['page'] ?? 'home';

// Check if page exists
$page_file = "src/pages/{$page}.php";
if (!file_exists($page_file)) {
    // Load 404 error page
    if (file_exists('error/404.html')) {
        include 'error/404.html';
        exit;
    } else {
        http_response_code(404);
        echo "Page not found";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kawakawa Inc. - Corporate Hub</title>
    <link rel="stylesheet" href="src/css/style.css">
</head>
<body>
    <?php include 'src/modules/navbar.php'; ?>
    
    <main class="container">
        <?php include $page_file; ?>
    </main>
    
    <?php include 'src/modules/footer.php'; ?>
    
    <script src="src/js/script.js"></script>
</body>
</html>