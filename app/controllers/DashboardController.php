<?php

namespace GCAS\Controllers;

use GCAS\Core\BaseController;
use GCAS\Models\Customer;

class DashboardController extends BaseController
{
   public function index(): void
{
    $this->requireLogin();

    $user = $_SESSION['user'];

    $customerModel = new Customer();

    $stats = [
        'customers'   => $customerModel->countCustomers(),
        'states'      => $customerModel->countStates(),
        'monthly'     => $customerModel->countMonthlyCustomers(),
        'topLocation' => $customerModel->getTopState()
    ];

    $recentCustomers = $customerModel->getRecentCustomers();

    $this->view('dashboard', [
        'user' => $user,
        'stats' => $stats,
        'recentCustomers' => $recentCustomers
    ]);
}
}