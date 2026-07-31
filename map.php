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

<title>Customer Map</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link
rel="stylesheet"
href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<style>

#map{

height:650px;

border-radius:10px;

}

</style>

</head>

<body class="bg-light">

<div class="container mt-4">

<h2>

📍 GeoCustomer Analytics Map

</h2>

<a href="dashboard.php"
class="btn btn-primary mb-3">

← Dashboard

</a>

<div id="map"></div>

</div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

var map=L.map('map').setView([9.0820,8.6753],6);

L.tileLayer(

'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',

{

attribution:'© OpenStreetMap'

}

).addTo(map);

<?php foreach($customers as $customer): ?>

<?php if(!empty($customer['latitude']) && !empty($customer['longitude'])): ?>

L.marker([

<?= $customer['latitude'] ?>,

<?= $customer['longitude'] ?>

])

.addTo(map)

.bindPopup(

"<b><?= addslashes($customer['first_name'].' '.$customer['last_name']) ?></b><br>"+

"<?= addslashes($customer['city']) ?>, <?= addslashes($customer['state']) ?><br>"+

"<?= addslashes($customer['phone']) ?>"

);

<?php endif; ?>

<?php endforeach; ?>

</script>

</body>

</html>