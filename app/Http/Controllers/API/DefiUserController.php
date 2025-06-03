<?php
// File: backend/app/Services/CompoundService.php
namespace App\Services;

use GuzzleHttp\Client;

class CompoundService
{
    protected Client $http;
    protected string $subgraph = 'https://api.thegraph.com/subgraphs/name/graphprotocol/compound-v2';

    public function __construct()
    {
        $this->http = new Client(['timeout'=>5.0]);
    }

    /**
     * Get user balances on Compound.
     */
    public function getUserPositions(string $userAddress): array
    {
        $query = <<<'GRAPHQL'
        query($user:String!){
          account(id:$user) {
            cTokenBalances {
              cToken {
                id
                symbol
                underlyingAddress
              }
              cTokenBalance
              borrowBalanceUnderlying
              supplyBalanceUnderlying
            }
          }
        }
        GRAPHQL;

        $resp = $this->http->post($this->subgraph, [
            'json'=>[
              'query'=>$query,
              'variables'=>['user'=>strtolower($userAddress)]
            ]
        ]);
        $data = json_decode($resp->getBody()->getContents(), true);
        return $data['data']['account']['cTokenBalances'] ?? [];
    }
}
