<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {

    header('Location: app/Views/login.php');
    exit;
}

$user = $_SESSION['user'];

?>

<!DOCTYPE html>

<html>

<head>

<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-body">

<h2>

Welcome,

<?= htmlspecialchars($user['full_name']) ?> 👋

</h2>

<p>

You have successfully logged into GCAS.

</p>

<hr>

<p>

<strong>Username:</strong>

<?= htmlspecialchars($user['username']) ?>

</p>

<p>

<strong>Email:</strong>

<?= htmlspecialchars($user['email']) ?>

</p>

<p>

<strong>Role:</strong>

<?= htmlspecialchars($user['role']) ?>

</p>

<a
href="logout.php"
class="btn btn-danger">

Logout

</a>

</div>

</div>

</div>

</body>

</html>