<?php

require_once __DIR__ . '/vendor/autoload.php';

use GCAS\Helpers\Geocoder;

$address = "1 Allen Avenue, Ikeja, Lagos, Nigeria";

$result = Geocoder::getCoordinates($address);

echo "<pre>";
print_r($result);