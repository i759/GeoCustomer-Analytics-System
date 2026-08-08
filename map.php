<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';
use GCAS\Models\Customer;

$customerModel = new Customer();
$customers = $customerModel->getAll();
$selectedId = filter_input(INPUT_GET, 'customer_id', FILTER_VALIDATE_INT);

$mapped = array_values(array_filter($customers, static function ($customer) {
    return $customer['latitude'] !== null && $customer['longitude'] !== null
        && (float)$customer['latitude'] !== 0.0 && (float)$customer['longitude'] !== 0.0;
}));
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Customer Map | GeoCustomer Analytics</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<style>
body{background:#f5f7fb}.map-card{border:0;border-radius:18px;overflow:hidden;box-shadow:0 8px 28px rgba(15,23,42,.08)}#map{height:calc(100vh - 210px);min-height:520px}.stat{border-radius:14px;background:#fff;padding:14px 18px;box-shadow:0 4px 16px rgba(15,23,42,.05)}
</style>
</head>
<body>
<div class="container-fluid px-3 px-lg-5 py-4">
 <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
  <div><div class="text-primary small fw-semibold">GIS CUSTOMER DISTRIBUTION</div><h2 class="fw-bold mb-1"><i class="bi bi-geo-alt-fill me-2"></i>Customer Map</h2><p class="text-muted mb-0">All successfully geocoded customer locations in one map.</p></div>
  <div class="d-flex gap-2"><a href="dashboard.php" class="btn btn-outline-secondary"><i class="bi bi-grid-1x2 me-1"></i>Dashboard</a><a href="customer_list.php" class="btn btn-primary"><i class="bi bi-people me-1"></i>Customers</a></div>
 </div>
 <div class="d-flex gap-3 mb-3"><div class="stat"><div class="small text-muted">Total customers</div><strong><?= count($customers) ?></strong></div><div class="stat"><div class="small text-muted">Mapped locations</div><strong><?= count($mapped) ?></strong></div><div class="stat"><div class="small text-muted">Unmapped</div><strong><?= count($customers)-count($mapped) ?></strong></div></div>
 <div class="card map-card"><div id="map"></div></div>
</div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const customers = <?= json_encode(array_map(static function($c){ return [
 'id'=>(int)$c['customer_id'],'name'=>trim($c['first_name'].' '.$c['last_name']),'address'=>trim(($c['street_address']??'').', '.($c['city']??'').', '.($c['state']??'')),'phone'=>$c['phone']??'','lat'=>$c['latitude']!==null?(float)$c['latitude']:null,'lng'=>$c['longitude']!==null?(float)$c['longitude']:null
]; }, $mapped), JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT) ?>;
const selectedId = <?= $selectedId ? (int)$selectedId : 'null' ?>;
const map=L.map('map');
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19,attribution:'© OpenStreetMap contributors'}).addTo(map);
const bounds=[];
customers.forEach(c=>{
 const marker=L.marker([c.lat,c.lng]).addTo(map).bindPopup(`<strong>${escapeHtml(c.name)}</strong><br>${escapeHtml(c.address)}<br>${escapeHtml(c.phone)}`);
 bounds.push([c.lat,c.lng]);
 if(selectedId===c.id){map.setView([c.lat,c.lng],17);marker.openPopup();}
});
if(!selectedId){if(bounds.length===1)map.setView(bounds[0],16);else if(bounds.length>1)map.fitBounds(bounds,{padding:[40,40],maxZoom:15});else map.setView([9.082,8.6753],6);}
function escapeHtml(value){return String(value??'').replace(/[&<>"']/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]));}
</script>
</body></html>
