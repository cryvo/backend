<?php
namespace App\Services;

use GuzzleHttp\Client;

class ChainalysisService
{
    protected Client $http;

    public function __construct()
    {
        $this->http = new Client([
            'base_uri' => config('services.chainalysis.base_url'),
            'timeout'  => 5.0,
            'headers'  => [
                'x-api-key' => config('services.chainalysis.api_key'),
                'Accept'    => 'application/json',
            ],
        ]);
    }

    /**
     * Returns true if address passes screening.
     */
    public function screenAddress(string $address): bool
    {
        $resp = $this->http->post('/aml/1/address', [
            'json' => ['address' => $address],
        ]);

        $data = json_decode($resp->getBody()->getContents(), true);
        return ($data['status'] ?? '') === 'CLEAR';
    }
}
