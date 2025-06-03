<?php
namespace App\Services;

use GuzzleHttp\Client;

class BridgeService
{
    protected Client $http;

    public function __construct()
    {
        $this->http = new Client([
            'base_uri' => 'https://li.quest/v1/',
            'timeout'  => 5.0,
        ]);
    }

    /**
     * Get a cross-chain quote.
     *
     * @param  string  $fromChain   Numeric chainId, e.g. '1' for Ethereum
     * @param  string  $toChain     Numeric chainId, e.g. '56' for BSC
     * @param  string  $fromToken   Token contract on source chain
     * @param  string  $toToken     Token contract on dest chain
     * @param  string  $amount      Amount in smallest unit (wei)
     */
    public function getQuote(
        string $fromChain,
        string $toChain,
        string $fromToken,
        string $toToken,
        string $amount
    ): array {
        $resp = $this->http->get('quote', [
            'query' => [
                'fromChain'         => $fromChain,
                'toChain'           => $toChain,
                'fromTokenAddress'  => $fromToken,
                'toTokenAddress'    => $toToken,
                'amount'            => $amount,
            ],
        ]);

        return json_decode($resp->getBody()->getContents(), true);
    }
}
