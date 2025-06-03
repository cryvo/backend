<?php
namespace App\Services;

use GuzzleHttp\Client;

class CoinPaymentService
{
    protected $client;
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://www.coinpayments.net/api.php',
            'auth'     => [config('services.coinpayments.public'), config('services.coinpayments.private')],
        ]);
    }

    public function getNewAddress($currency, $ipnUrl)
    {
        $response = $this->client->post('', [
            'form_params' => [
                'version'=>1,
                'cmd'=>'get_callback_address',
                'currency'=>$currency,
                'ipn_url'=>$ipnUrl,
            ]
        ]);
        $json = json_decode($response->getBody(), true);
        return $json['result']['address'] ?? null;
    }
}
