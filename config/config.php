<?php
/**
 * GeoCustomer Analytics System (GCAS)
 * Application Configuration
 */

// Application Settings
define('APP_NAME', 'GeoCustomer Analytics System');
define('APP_VERSION', '1.0');

// Base URL
define('BASE_URL', 'http://localhost/GCAS');

// Database Settings
define('DB_HOST', 'localhost');
define('DB_NAME', 'gcas_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Timezone
date_default_timezone_set('Africa/Lagos');

// Start session if it hasn't already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}