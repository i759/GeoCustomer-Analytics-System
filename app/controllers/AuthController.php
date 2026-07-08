<?php

namespace GCAS\Controllers;

use GCAS\Models\User;

class AuthController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login(string $login, string $password): bool
    {
        $user = $this->userModel->findByLogin($login);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        session_start();

        $_SESSION['user'] = [
            'id' => $user['id'],
            'full_name' => $user['full_name'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role']
        ];

        return true;
    }

    public function logout(): void
    {
        session_start();

        session_destroy();

        header('Location: index.php');
        exit;
    }
}