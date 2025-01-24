<?php
// Defina sua chave de API
$apiKey = 'AIzaSyCbtWv3-GmBu51RfnTgtqYt3Tz09hYsyoo';

// URL da API de rotas do Google
$url = 'https://routes.googleapis.com/directions/v2:computeRoutes';

// JSON da requisição
$data = [
    "origin" => [
        "location" => [
            "latLng" => [
                "latitude" => -24.636254,
                "longitude" => -53.934500
            ]
        ]
    ],
    "destination" => [
        "location" => [
            "latLng" => [
                "latitude" => -24.615410,
                "longitude" => -53.909963
            ]
        ]
    ],
    "intermediates" => [
        [
            "location" => [
                "latLng" => [
                    "latitude" => -24.638304,
                    "longitude" => -53.936754
                ]
            ]
        ],
        [
            "location" => [
                "latLng" => [
                    "latitude" => -24.640092,
                    "longitude" => -53.936417
                ]
            ]
        ],
        [
            "location" => [
                "latLng" => [
                    "latitude" => -24.631157,
                    "longitude" => -53.939926
                ]
            ]
        ],
        [
            "location" => [
                "latLng" => [
                    "latitude" => -24.629771,
                    "longitude" => -53.947003
                ]
            ]
        ],
        [
            "location" => [
                "latLng" => [
                    "latitude" => -24.624503,
                    "longitude" => -53.928527
                ]
            ]
        ],
        [
            "location" => [
                "latLng" => [
                    "latitude" => -24.632321,
                    "longitude" => -53.918234
                ]
            ]
        ],
        [
            "location" => [
                "latLng" => [
                    "latitude" => -24.643235,
                    "longitude" => -53.919911
                ]
            ]
        ],
        [
            "location" => [
                "latLng" => [
                    "latitude" => -24.625847,
                    "longitude" => -53.917974
                ]
            ]
        ],
        [
            "location" => [
                "latLng" => [
                    "latitude" => -24.618976,
                    "longitude" => -53.927027
                ]
            ]
        ],
        [
            "location" => [
                "latLng" => [
                    "latitude" => -24.617759,
                    "longitude" => -53.929228
                ]
            ]
        ],
        [
            "location" => [
                "latLng" => [
                    "latitude" => -24.603700,
                    "longitude" => -53.929414
                ]
            ]
        ],
        [
            "location" => [
                "latLng" => [
                    "latitude" => -24.602474,
                    "longitude" => -53.928396
                ]
            ]
        ],
        [
            "location" => [
                "latLng" => [
                    "latitude" => -24.593176,
                    "longitude" => -53.922822
                ]
            ]
        ],
        [
            "location" => [
                "latLng" => [
                    "latitude" => -24.582778,
                    "longitude" => -53.907347
                ]
            ]
        ],
        [
            "location" => [
                "latLng" => [
                    "latitude" => -24.608470,
                    "longitude" => -53.917019
                ]
            ]
        ],
        [
            "location" => [
                "latLng" => [
                    "latitude" => -24.608454,
                    "longitude" => -53.916818
                ]
            ]
        ],
        [
            "location" => [
                "latLng" => [
                    "latitude" => -24.599500,
                    "longitude" => -53.914386
                ]
            ]
        ],
        [
            "location" => [
                "latLng" => [
                    "latitude" => -24.601368,
                    "longitude" => -53.911180
                ]
            ]
        ],
        [
            "location" => [
                "latLng" => [
                    "latitude" => -24.610193,
                    "longitude" => -53.907765
                ]
            ]
        ]
    ],
    "travelMode" => "DRIVE",
    "routingPreference" => "TRAFFIC_AWARE",
    "languageCode" => "pt-BR",
    "units" => "METRIC"
];

// Inicialize o cURL
$ch = curl_init();

// Configurações do cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-Goog-Api-Key: ' . $apiKey, // Adiciona a chave de API como cabeçalho
    //'X-Goog-FieldMask: routes.,routes.distanceMeters,routes.polyline.encodedPolyline', // Exemplo de FieldMask para limitar os campos retornados
    'X-Goog-FieldMask: *', // Exemplo de FieldMask para limitar os campos retornados
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Especificar o caminho para o arquivo cacert.pem
curl_setopt($ch, CURLOPT_CAINFO, 'C:\laragon\bin\cacert.pem');

// Execute a requisição
$response = curl_exec($ch);

// Verifique se houve algum erro
if ($response === false) {
    echo 'Erro na requisição: ' . curl_error($ch);
} else {
    // Decodifique a resposta JSON
    $result = json_decode($response, true);

    // Exiba os resultados
    if (isset($result['routes'])) {
        foreach ($result['routes'] as $route) {
            echo "Distância: " . $route['distanceMeters'] . " metros\n";
            echo "Duração: " . $route['duration'] . "\n";
            
            // Decodificando a polilinha para mostrar pontos da rota
            if (isset($route['polyline']['encodedPolyline'])) {
                echo "Polyline: " . $route['polyline']['encodedPolyline'] . "\n";
            }
        }
        print_r($response); 
    } else {
        echo "Resposta da API não contém rotas.\n";
        print_r($result);
    }
}

// Feche a conexão cURL
curl_close($ch);
?>