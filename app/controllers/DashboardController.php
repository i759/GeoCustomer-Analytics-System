<?php

namespace GCAS\Controllers;

use GCAS\Core\BaseController;

class DashboardController extends BaseController
{
    public function index(): void
    {
        $this->requireLogin();

        $user = $_SESSION['user'];

        $stats = [
            'customers' => 0,
            'states' => 0,
            'monthly' => 0,
            'topLocation' => 'N/A'
        ];

        $recentCustomers = [];

        $this->view('dashboard', [
            'user' => $user,
            'stats' => $stats,
            'recentCustomers' => $recentCustomers
        ]);
    }
}