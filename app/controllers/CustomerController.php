<?php

namespace GCAS\Controllers;

use GCAS\Models\Customer;
use GCAS\Helpers\Geocoder;

class CustomerController
{
    private Customer $customerModel;

    public function __construct()
    {
        $this->customerModel = new Customer();
    }

    public function create(): void
    {
        require __DIR__ . '/../Views/customers/create.php';
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=customer_create');
            exit;
        }

        $customer = $this->buildCustomerData($_POST);
        if ($this->customerModel->create($customer)) {
            $_SESSION['success'] = 'Customer added successfully.';
            header('Location: index.php?page=customer_list');
            exit;
        }

        $_SESSION['error'] = 'Unable to save customer.';
        header('Location: index.php?page=customer_create');
        exit;
    }

    public function index(): void
    {
        $customers = $this->customerModel->getAll();
        require __DIR__ . '/../Views/customers/index.php';
    }

    public function show(int $id): void
    {
        $customer = $this->customerModel->find($id);
        if (!$customer) {
            $_SESSION['error'] = 'Customer not found.';
            header('Location: index.php?page=customer_list');
            exit;
        }
        require __DIR__ . '/../Views/customers/show.php';
    }

    public function edit(int $id): void
    {
        $customer = $this->customerModel->find($id);
        if (!$customer) {
            $_SESSION['error'] = 'Customer not found.';
            header('Location: index.php?page=customer_list');
            exit;
        }
        require __DIR__ . '/../Views/customers/edit.php';
    }

    public function update(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=customer_edit&id=' . $id);
            exit;
        }

        if (!$this->customerModel->find($id)) {
            $_SESSION['error'] = 'Customer not found.';
            header('Location: index.php?page=customer_list');
            exit;
        }

        if ($this->customerModel->update($id, $this->buildCustomerData($_POST, false))) {
            $_SESSION['success'] = 'Customer updated successfully.';
        } else {
            $_SESSION['error'] = 'Unable to update customer.';
        }

        header('Location: index.php?page=customer_list');
        exit;
    }

    public function delete(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=customer_list');
            exit;
        }

        if ($this->customerModel->delete($id)) {
            $_SESSION['success'] = 'Customer deleted successfully.';
        } else {
            $_SESSION['error'] = 'Unable to delete customer.';
        }

        header('Location: index.php?page=customer_list');
        exit;
    }

    public function analytics(): void
    {
        $stateData = $this->customerModel->customersByState();
        $monthlyData = $this->customerModel->monthlyRegistrations();
        require __DIR__ . '/../Views/customers/analytics.php';
    }

    private function buildCustomerData(array $input, bool $includeCode = true): array
    {
        $fullAddress = implode(', ', array_filter([
            trim($input['street_address'] ?? ''),
            trim($input['city'] ?? ''),
            trim($input['state'] ?? ''),
            trim($input['country'] ?? 'Nigeria')
        ]));

        $coordinates = Geocoder::getCoordinates($fullAddress);

        $data = [
            'first_name' => trim($input['first_name'] ?? ''),
            'last_name' => trim($input['last_name'] ?? ''),
            'phone' => trim($input['phone'] ?? ''),
            'email' => trim($input['email'] ?? ''),
            'street_address' => trim($input['street_address'] ?? ''),
            'city' => trim($input['city'] ?? ''),
            'state' => trim($input['state'] ?? ''),
            'country' => trim($input['country'] ?? 'Nigeria'),
            'latitude' => $coordinates['latitude'],
            'longitude' => $coordinates['longitude'],
        ];

        if ($includeCode) {
            $data['customer_code'] = $this->generateCustomerCode();
        }

        return $data;
    }

    private function generateCustomerCode(): string
    {
        return 'CUS' . date('Y') . strtoupper(bin2hex(random_bytes(3)));
    }
}
