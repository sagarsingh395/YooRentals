<?php
function paypalAccessToken()
{
    $clientId = getenv('PAYPAL_CLIENT_ID');
    $secret   = getenv('PAYPAL_SECRET');
    $baseURL  = getenv('PAYPAL_BASE_URL');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $baseURL . "/v1/oauth2/token");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "$clientId:$secret");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

    $headers = [
        "Accept: application/json",
        "Accept-Language: en_US"
    ];

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($result, true);
    return $json['access_token'] ?? null;
}

function getLiveUsdRate()
{
    try {
        $url = "https://open.er-api.com/v6/latest/INR";
        $response = @file_get_contents($url);
        
        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['rates']['USD'])) {
                return $data['rates']['USD'];
            }
        }
    } catch (\Exception $e) {
        return 0.012; 
    }
    return 0.012; 
}