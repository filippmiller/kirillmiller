<?php
/**
 * PHP Built-in Server Router
 *
 * This file handles routing for PHP's built-in development server
 * and Railway deployment. It serves static files directly and routes
 * all other requests to index.php.
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve static files directly if they exist
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    // Check if it's a PHP file in allowed directories
    if (preg_match('/\.php$/', $uri)) {
        // Allow admin directory PHP files
        if (strpos($uri, '/admin/') === 0) {
            return false; // Let PHP built-in server handle it
        }
        // Block direct access to other PHP files except index.php
        if ($uri !== '/index.php') {
            http_response_code(403);
            echo 'Forbidden';
            return true;
        }
    }
    return false; // Serve the file directly
}

// Route everything else to index.php
require __DIR__ . '/index.php';
