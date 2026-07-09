<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';

use GCAS\Controllers\AuthController;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user'])) {
    header('Location: ../../dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    $auth = new AuthController();

    $result = $auth->login($login, $password);

    if ($result['success']) {

        header('Location: ../../dashboard.php');
        exit;

    } else {

        $error = $result['message'];

    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>GCAS Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{
            background:#f5f7fb;
            height:100vh;
        }

        .login-card{
            border:none;
            border-radius:18px;
            box-shadow:0 15px 40px rgba(0,0,0,.08);
        }

        .brand{
            font-size:30px;
            font-weight:bold;
            color:#0d6efd;
        }

    </style>

</head>

<body>

<div class="container h-100">

<div class="row h-100 justify-content-center align-items-center">

<div class="col-md-5">

<div class="card login-card">

<div class="card-body p-5">
    <?php if (!empty($error)): ?>

<div class="alert alert-danger">

    <?= htmlspecialchars($error) ?>

</div>

<?php endif; ?>

<div class="text-center mb-4">

<h2 class="brand">GCAS</h2>

<p class="text-muted">
GeoCustomer Analytics System
</p>

</div>

<form method="POST">

<div class="mb-3">

<label class="form-label">

Username or Email

</label>

<input
type="text"
class="form-control"
name="login"
required>

</div>

<div class="mb-3">

<label class="form-label">

Password

</label>

<div class="input-group">

<input
type="password"
class="form-control"
id="password"
name="password"
required>

<button
class="btn btn-outline-secondary"
type="button"
id="togglePassword">

<i class="bi bi-eye"></i>

</button>

</div>

</div>

<div class="form-check mb-4">

<input
class="form-check-input"
type="checkbox">

<label class="form-check-label">

Remember Me

</label>

</div>

<div class="d-grid">

<button
class="btn btn-primary"
type="submit">

Login

</button>

</div>

</form>

<hr>

<div class="text-center text-muted">

© 2026 GeoCustomer Analytics System

</div>

</div>

</div>

</div>

</div>

</div>

<script>

const password=document.getElementById('password');

const toggle=document.getElementById('togglePassword');

toggle.addEventListener('click',()=>{

const type=password.type==="password"
?"text":"password";

password.type=type;

toggle.innerHTML=type==="password"
?'<i class="bi bi-eye"></i>'
:'<i class="bi bi-eye-slash"></i>';

});

</script>

</body>

</html>