<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';

use GCAS\Models\Customer;

$customerModel = new Customer();
$customers = $customerModel->getAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Customer List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h2 class="mb-4">
        Customer List
    </h2>

    <a href="dashboard.php" class="btn btn-primary mb-3">
        ← Back to Dashboard
    </a>

    <table class="table table-bordered table-striped">

        <thead class="table-dark">

        <tr>
            <th>Customer Code</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>City</th>
            <th>State</th>
            <th>Country</th>
        </tr>

        </thead>

        <tbody>

        <?php if(empty($customers)): ?>

            <tr>
                <td colspan="7" class="text-center">
                    No customers found.
                </td>
            </tr>

        <?php else: ?>

            <?php foreach($customers as $customer): ?>

            <tr>

                <td><?= htmlspecialchars($customer['customer_code']) ?></td>

                <td>
                    <?= htmlspecialchars($customer['first_name']) ?>
                    <?= htmlspecialchars($customer['last_name']) ?>
                </td>

                <td><?= htmlspecialchars($customer['phone']) ?></td>

                <td><?= htmlspecialchars($customer['email']) ?></td>

                <td><?= htmlspecialchars($customer['city']) ?></td>

                <td><?= htmlspecialchars($customer['state']) ?></td>

                <td><?= htmlspecialchars($customer['country']) ?></td>

            </tr>

            <?php endforeach; ?>

        <?php endif; ?>

        </tbody>

    </table>

</div>

</body>

</html>