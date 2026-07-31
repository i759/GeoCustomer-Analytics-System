<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';

use GCAS\Controllers\AuthController;

$auth = new AuthController();

if ($auth->login('admin', 'Admin@123')) {
    echo "<h2>✅ Login Successful</h2>";
} else {
    echo "<h2>❌ Login Failed</h2>";
}