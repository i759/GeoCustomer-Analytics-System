<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
} else {
    header('Location: app/Views/login.php');
}

exit;