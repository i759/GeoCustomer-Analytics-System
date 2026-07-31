<?php

namespace GCAS\Controllers;

use GCAS\Models\User;

use GCAS\Core\BaseController;

class AuthController extends BaseController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login(string $login, string $password): array
    {
        $user = $this->userModel->findByLogin($login);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Invalid username/email or password.'
            ];
        }

        if ($user['status'] !== 'Active') {
            return [
                'success' => false,
                'message' => 'Your account is inactive. Please contact the administrator.'
            ];
        }

        if (!password_verify($password, $user['password'])) {
            return [
                'success' => false,
                'message' => 'Invalid username/email or password.'
            ];
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_regenerate_id(true);

        $this->userModel->updateLastLogin($user['id']);

        $_SESSION['user'] = [
            'id' => $user['id'],
            'full_name' => $user['full_name'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role']
        ];

        return [
            'success' => true,
            'message' => 'Login successful.'
        ];
    }

    public function logout(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();

    header('Location: index.php');
    exit;
}
}