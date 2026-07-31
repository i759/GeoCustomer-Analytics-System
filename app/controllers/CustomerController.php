<?php

namespace GCAS\Controllers;

use GCAS\Models\Customer;

class CustomerController
{
    private Customer $customerModel;

    public function __construct()
    {
        $this->customerModel = new Customer();
    }

    /**
     * Display Add Customer Form
     */
    public function create()
    {
        require __DIR__ . '/../Views/customers/create.php';
    }

    /**
     * Save Customer
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=add_customer");
            exit;
        }

        $customer = [
            'customer_code' => $this->generateCustomerCode(),
            'first_name'    => trim($_POST['first_name']),
            'last_name'     => trim($_POST['last_name']),
            'phone'         => trim($_POST['phone']),
            'email'         => trim($_POST['email']),
            'street_address'       => trim($_POST['street_address']),
            'city'          => trim($_POST['city']),
            'state'         => trim($_POST['state']),
            'country'       => trim($_POST['country']),
            'latitude'      => $_POST['latitude'],
            'longitude'     => $_POST['longitude']
        ];

        if ($this->customerModel->create($customer)) {

            $_SESSION['success'] = "Customer added successfully.";

            header("Location: index.php?page=customers");

            exit;
        }

        $_SESSION['error'] = "Unable to save customer.";

        header("Location: index.php?page=add_customer");
    }

    /**
     * Generate Customer Code
     */
    private function generateCustomerCode()
    {
        return 'CUS' . date('Y') . rand(1000,9999);
    }
}