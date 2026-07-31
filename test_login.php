<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';

use GCAS\Controllers\AuthController;

$auth = new AuthController();

$result = $auth->login('admin', 'Admin@123');

echo "<pre>";
print_r($result);
echo "</pre>";