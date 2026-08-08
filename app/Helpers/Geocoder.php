<?php

namespace GCAS\Helpers;

class Geocoder
{
    /**
     * Resolve an address to coordinates using OpenStreetMap Nominatim.
     * Tries the complete address first, then progressively broader queries.
     * Returns null coordinates when no reliable result is available rather
     * than silently storing 0,0 (which is not a valid customer location).
     */
    public static function getCoordinates(string $address): array
    {
        $parts = array_values(array_filter(array_map('trim', preg_split('/,/', $address))));
        $queries = [];

        for ($i = 0; $i < count($parts); $i++) {
            $query = implode(', ', array_slice($parts, $i));
            if ($query !== '' && !in_array($query, $queries, true)) {
                $queries[] = $query;
            }
        }

        // Prefer a Nigeria-qualified query for local data when the country
        // field is omitted or abbreviated.
        if (!empty($parts) && stripos(implode(' ', $parts), 'nigeria') === false) {
            $queries[] = implode(', ', $parts) . ', Nigeria';
        }

        foreach ($queries as $query) {
            $result = self::search($query);
            if ($result !== null) {
                return $result;
            }
        }

        return [
            'latitude' => null,
            'longitude' => null,
        ];
    }

    private static function search(string $query): ?array
    {
        $url = 'https://nominatim.openstreetmap.org/search?' . http_build_query([
            'q' => $query,
            'format' => 'jsonv2',
            'limit' => 1,
            'addressdetails' => 1,
            'countrycodes' => 'ng',
        ]);

        $opts = [
            'http' => [
                'method' => 'GET',
                'timeout' => 10,
                'ignore_errors' => true,
                'header' => "User-Agent: GeoCustomer-Analytics-System/1.0 (GIS customer mapping)\r\nAccept: application/json\r\n",
            ],
        ];

        $context = stream_context_create($opts);
        $response = @file_get_contents($url, false, $context);
        if ($response === false || trim($response) === '') {
            return null;
        }

        $data = json_decode($response, true);
        if (!is_array($data) || empty($data[0])) {
            return null;
        }

        $lat = filter_var($data[0]['lat'] ?? null, FILTER_VALIDATE_FLOAT);
        $lon = filter_var($data[0]['lon'] ?? null, FILTER_VALIDATE_FLOAT);

        if ($lat === false || $lon === false || !is_finite($lat) || !is_finite($lon)) {
            return null;
        }

        return [
            'latitude' => (float) $lat,
            'longitude' => (float) $lon,
        ];
    }
}
