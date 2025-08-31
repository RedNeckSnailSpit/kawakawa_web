<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Page Showcase | Kawakawa Inc.</title>
    <link rel="stylesheet" href="src/css/style.css">
</head>
<body>
    <?php include 'src/modules/navbar.php'; ?>
    
    <main class="container">
        <div class="card">
            <h2>Error Page Showcase</h2>
            <p>Check out some cool error pages. Click any button below to see how we handle different HTTP status codes with style.</p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 2rem;">
                <a href="error/400.html" class="btn">400 - Bad Request</a>
                <a href="error/401.html" class="btn">401 - Unauthorized</a>
                <a href="error/403.html" class="btn">403 - Forbidden</a>
                <a href="error/404.html" class="btn">404 - Not Found</a>
                <a href="error/405.html" class="btn">405 - Method Not Allowed</a>
                <a href="error/500.html" class="btn">500 - Server Error</a>
                <a href="error/502.html" class="btn">502 - Bad Gateway</a>
                <a href="error/503.html" class="btn">503 - Service Unavailable</a>
            </div>
            
            <div style="margin-top: 2rem; padding: 1rem; background: rgba(0, 212, 255, 0.1); border-radius: 5px;">
                <p><strong>Note:</strong> These are static HTML files showcasing our corporate error page designs. In production, these would be served automatically by the web server when the corresponding HTTP status codes occur.</p>
            </div>
        </div>
    </main>
    
    <?php include 'src/modules/footer.php'; ?>
    
    <script src="src/js/script.js"></script>
</body>
</html>