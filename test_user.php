<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';

use GCAS\Models\User;

$user = new User();

$result = $user->findByLogin('admin');

echo "<pre>";
print_r($result);
echo "</pre>";