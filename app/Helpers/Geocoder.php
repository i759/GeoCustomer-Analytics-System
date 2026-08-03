<?php

namespace GCAS\Helpers;

class Geocoder
{
    public static function getCoordinates(string $address): array
    {
        $url = "https://nominatim.openstreetmap.org/search?" .
               http_build_query([
                   'q' => $address,
                   'format' => 'json',
                   'limit' => 1
               ]);

        $opts = [
            "http" => [
                "header" => "User-Agent: GCAS/1.0\r\n"
            ]
        ];

        $context = stream_context_create($opts);

        $response = file_get_contents($url, false, $context);

        $data = json_decode($response, true);

        if (!empty($data)) {
            return [
                'latitude' => $data[0]['lat'],
                'longitude' => $data[0]['lon']
            ];
        }

        return [
            'latitude' => 0,
            'longitude' => 0
        ];
    }
}