<?php
require_once 'vendor/autoload.php';

use Google\Client;

// Caminho para o arquivo de chave JSON da sua conta de serviço
$serviceAccountPath = 'C:\\laragon\\www\\light-lacing-436512-n0-3931a50c7c4b.json';

if (!file_exists($serviceAccountPath)) {
    die("Erro: O arquivo JSON da conta de serviço não foi encontrado no caminho especificado.");
}

// Cria o cliente do Google OAuth 2.0
$client = new Client();
$client->setAuthConfig($serviceAccountPath);
$client->addScope('https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/cloud-platform');

// Obtém o token de acesso
$token = $client->fetchAccessTokenWithAssertion();

if (isset($token['error'])) {
    die("Erro ao obter o token de acesso: " . $token['error_description']);
}

// URL da API de Validação de Endereços
$url = "https://addressvalidation.googleapis.com/v1:validateAddress";

// Dados do endereço que você deseja validar
$data = [
    "address" => [
        "regionCode" => "BR",
        "locality" => "Toledo",
        "addressLines" => ["Rua Jose Angelo Borges, 103"],
        "administrativeArea" => "PR"
    ]
];

// Configuração do cURL para chamada à API com OAuth 2.0
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token['access_token'], // Adiciona o token de acesso no cabeçalho
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Executa a chamada à API
$response = curl_exec($ch);

// Verifica se ocorreu um erro
if ($response === false) {
    echo "Erro na chamada cURL: " . curl_error($ch);
    exit;
}

// Decodifica a resposta JSON
$responseData = json_decode($response, true);

// Exibe a resposta da API
echo "<pre>";
print_r($responseData);
echo "</pre>";

// Fecha a conexão cURL
curl_close($ch);
?>
