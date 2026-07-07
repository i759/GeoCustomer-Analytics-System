<?php

require_once 'config/config.php';
require_once 'config/Database.php';

$database = new Database();
$conn = $database->connect();

if ($conn) {
    echo "<h2>✅ Database Connected Successfully!</h2>";
} else {
    echo "<h2>❌ Database Connection Failed!</h2>";
}