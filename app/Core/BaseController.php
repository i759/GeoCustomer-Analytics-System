<?php

namespace GCAS\Core;

class BaseController
{
    /**
     * Load a view.
     */
    protected function view(string $view, array $data = []): void
    {
        extract($data);

        require_once __DIR__ . "/../Views/{$view}.php";
    }

    /**
     * Redirect to another page.
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Ensure a user is logged in.
     */
    protected function requireLogin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            $this->redirect('/GCAS/index.php');
        }
    }
}