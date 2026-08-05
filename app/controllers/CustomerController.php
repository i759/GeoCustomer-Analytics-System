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
$fullAddress =
    trim($_POST['street_address']) . ", " .
    trim($_POST['city']) . ", " .
    trim($_POST['state']) . ", " .
    trim($_POST['country']);

$coordinates = Geocoder::getCoordinates($fullAddress);

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
            'latitude' => $coordinates['latitude'],
            'longitude' => $coordinates['longitude']
        ];

        if ($this->customerModel->create($customer)) {

            $_SESSION['success'] = "Customer added successfully.";

            header("Location: index.php?page=customer_list.php");

            exit;
        }

        $_SESSION['error'] = "Unable to save customer.";

        header("Location: index.php?page=customer_create.php");
    }
/**
 * Display all Customers
 */
public function index()
{
    $customers = $this->customerModel->getAll();

    require __DIR__ . '/../Views/customers/index.php';
}
    /**
     * Generate Customer Code
     */
    private function generateCustomerCode()
    {
        return 'CUS' . date('Y') . rand(1000,9999);
    }
    /**
 * Analytics Dashboard
 */
    public function analytics()
{
    $stateData = $this->customerModel->customersByState();

    $monthlyData = $this->customerModel->monthlyRegistrations();

    require __DIR__ . '/../Views/customers/analytics.php';
}
}