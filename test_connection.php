<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';

use GCAS\Core\Database;

$database = new Database();
$conn = $database->connect();

if ($conn) {
    echo "<h2>✅ Database Connected Successfully!</h2>";
} else {
    echo "<h2>❌ Database Connection Failed!</h2>";
}