<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">

<div class="container-fluid">

<span class="navbar-brand">

GeoCustomer Analytics System

</span>

<div class="text-white">

Welcome,

<strong><?= htmlspecialchars($user['full_name']) ?></strong>

|

<a href="/GCAS/logout.php"
class="btn btn-outline-light btn-sm">

<i class="bi bi-box-arrow-right"></i>

Logout

</a>

</div>

</div>

</nav>

<div class="container mt-4">

<div class="row g-4">

<div class="col-md-3">

<div class="card shadow-sm">

<div class="card-body text-center">

<h5>Total Customers</h5>

<h2><?= $stats['customers'] ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow-sm">

<div class="card-body text-center">

<h5>States</h5>

<h2><?= $stats['states'] ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow-sm">

<div class="card-body text-center">

<h5>This Month</h5>

<h2><?= $stats['monthly'] ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow-sm">

<div class="card-body text-center">

<h5>Top Area</h5>

<h2><?= htmlspecialchars($stats['topLocation']) ?></h2>

</div>

</div>

</div>

</div>

<div class="row mt-4">

<div class="col-md-8">

<div class="card shadow-sm">

<div class="card-header">

Recent Customers

</div>

<div class="card-body">

<?php if (empty($recentCustomers)): ?>

    <p class="text-muted">No customers yet.</p>

<?php else: ?>

<table class="table table-striped">

    <thead>
        <tr>
            <th>Customer</th>
            <th>Phone</th>
            <th>State</th>
        </tr>
    </thead>

    <tbody>

    <?php foreach ($recentCustomers as $customer): ?>

        <tr>

            <td>
                <?= htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']) ?>
            </td>

            <td><?= htmlspecialchars($customer['phone']) ?></td>

            <td><?= htmlspecialchars($customer['state']) ?></td>

        </tr>

    <?php endforeach; ?>

    </tbody>

</table>

<?php endif; ?>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card shadow-sm">

<div class="card-header">

Quick Actions

</div>

<div class="list-group list-group-flush">
<a href="map.php" class="list-group-item">
    <i class="bi bi-geo-alt-fill me-2"></i>
    Customer Map
</a>
<a href="customer_create.php" class="list-group-item">
    <i class="bi bi-plus-lg me-2"></i>
    Add Customer
</a>

<a href="customer_list.php" class="list-group-item">
    <i class="bi bi-people-fill me-2"></i>
    Customer List
</a>

<a href="#" class="list-group-item">
    <i class="bi bi-map me-2"></i>
    View Map
</a>

<a href="analytics.php"
class="list-group-item">
<i class="bi bi-bar-chart-fill me-2"></i>
Analytics

</a>

</div>

</div>

</div>

</div>

</div>

</body>

</html>
<script>

const stateLabels =
<?= json_encode(array_column($stateData,'state')); ?>;

const stateTotals =
<?= json_encode(array_column($stateData,'total')); ?>;

new Chart(document.getElementById('stateChart'),{

type:'bar',

data:{

labels:stateLabels,

datasets:[{

label:'Customers',

data:stateTotals

}]

}

});

</script>