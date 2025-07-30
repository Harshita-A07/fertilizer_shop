<?php
function getAccessToken($jsonKeyPath) {
    $credentials = json_decode(file_get_contents($jsonKeyPath), true);
    $now = time();

    $header = ['alg' => 'RS256', 'typ' => 'JWT'];
    $claim = [
        'iss' => $credentials['client_email'],
        'scope' => 'https://www.googleapis.com/auth/cloud-platform',
        'aud' => 'https://oauth2.googleapis.com/token',
        'exp' => $now + 3600,
        'iat' => $now
    ];

    $jwtHeader = base64_encode(json_encode($header));
    $jwtClaim = base64_encode(json_encode($claim));
    $jwtUnsigned = "$jwtHeader.$jwtClaim";

    openssl_sign($jwtUnsigned, $signature, $credentials['private_key'], 'sha256WithRSAEncryption');
    $jwtSignature = base64_encode($signature);
    $jwt = "$jwtUnsigned.$jwtSignature";

    $response = file_get_contents('https://oauth2.googleapis.com/token', false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded",
            'content' => http_build_query([
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt
            ])
        ]
    ]));

    $data = json_decode($response, true);
    return $data['access_token'] ?? null;
}
?>
