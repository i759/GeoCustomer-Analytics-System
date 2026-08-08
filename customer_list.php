<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';

use GCAS\Models\Customer;

$customerModel = new Customer();
$customers = $customerModel->getAll();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer List | GeoCustomer Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f5f7fb; }
        .page-card { border: 0; border-radius: 18px; box-shadow: 0 8px 28px rgba(15,23,42,.07); }
        .table > :not(caption) > * > * { padding: .9rem .75rem; vertical-align: middle; }
        .customer-name { font-weight: 600; color: #172033; }
        .action-btn { width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; }
    </style>
</head>
<body>
<div class="container-fluid px-3 px-lg-5 py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <div class="text-primary fw-semibold small text-uppercase">Customer Management</div>
            <h2 class="fw-bold mb-1">Customers</h2>
            <p class="text-muted mb-0">View, edit, locate, or remove customer records.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="dashboard.php" class="btn btn-outline-secondary"><i class="bi bi-grid-1x2 me-1"></i> Dashboard</a>
            <a href="customer_create.php" class="btn btn-primary"><i class="bi bi-person-plus me-1"></i> Add Customer</a>
        </div>
    </div>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($_SESSION['success']) ?><button class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($_SESSION['error']) ?><button class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="card page-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>Customer</th><th>Code</th><th>Phone</th><th>Email</th><th>Location</th><th>Coordinates</th><th class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($customers)): ?>
                        <tr><td colspan="7" class="text-center py-5 text-muted"><i class="bi bi-people fs-2 d-block mb-2"></i>No customers found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($customers as $customer): ?>
                            <?php $id = (int)$customer['customer_id']; $hasCoordinates = $customer['latitude'] !== null && $customer['longitude'] !== null && (float)$customer['latitude'] !== 0.0 && (float)$customer['longitude'] !== 0.0; ?>
                            <tr>
                                <td><div class="customer-name"><?= htmlspecialchars(trim($customer['first_name'].' '.$customer['last_name'])) ?></div></td>
                                <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($customer['customer_code']) ?></span></td>
                                <td><?= htmlspecialchars($customer['phone'] ?? '—') ?></td>
                                <td><?= htmlspecialchars($customer['email'] ?? '—') ?></td>
                                <td><?= htmlspecialchars(trim(($customer['city'] ?? '').', '.($customer['state'] ?? ''))) ?></td>
                                <td><?= $hasCoordinates ? '<span class="badge text-bg-success">Mapped</span>' : '<span class="badge text-bg-warning">Not mapped</span>' ?></td>
                                <td class="text-end text-nowrap">
                                    <a class="btn btn-outline-info action-btn" title="View" href="customer_action.php?action=view&id=<?= $id ?>"><i class="bi bi-eye"></i></a>
                                    <a class="btn btn-outline-primary action-btn" title="Edit" href="customer_action.php?action=edit&id=<?= $id ?>"><i class="bi bi-pencil"></i></a>
                                    <form class="d-inline" method="post" action="customer_action.php?action=delete&id=<?= $id ?>" onsubmit="return confirm('Delete this customer? This cannot be undone.');">
                                        <button class="btn btn-outline-danger action-btn" title="Delete" type="submit"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
