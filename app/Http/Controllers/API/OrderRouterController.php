<?php
namespace App\Services;

use GuzzleHttp\Client;

class MatchingEngineService
{
    protected Client $http;

    public function __construct()
    {
        $this->http = new Client([
            'base_uri' => env('MATCHING_ENGINE_URL', 'http://127.0.0.1:3002'),
            'timeout'  => 2.0,
        ]);
    }

    /** Fetch order book from Rust engine */
    public function getOrderBook(string $symbol): array
    {
        $res = $this->http->get("/orderbook/{$symbol}");
        return json_decode($res->getBody()->getContents(), true);
    }

    /** Place an order via Rust engine */
    public function placeOrder(array $data): array
    {
        $res = $this->http->post('/order', [
            'json' => $data,
        ]);
        return json_decode($res->getBody()->getContents(), true);
    }
}
