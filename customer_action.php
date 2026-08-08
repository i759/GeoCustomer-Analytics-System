<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';

use GCAS\Controllers\CustomerController;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$action = $_GET['action'] ?? '';

if (!$id || !in_array($action, ['view', 'edit', 'update', 'delete'], true)) {
    $_SESSION['error'] = 'Invalid customer action.';
    header('Location: customer_list.php');
    exit;
}

$controller = new CustomerController();

switch ($action) {
    case 'view':
        $controller->show($id);
        break;
    case 'edit':
        $controller->edit($id);
        break;
    case 'update':
        $controller->update($id);
        break;
    case 'delete':
        $controller->delete($id);
        break;
}
