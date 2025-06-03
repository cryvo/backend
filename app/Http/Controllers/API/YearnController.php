<?php
namespace App\Services;

use GuzzleHttp\Client;

class UniswapService
{
    protected Client $http;
    protected string $subgraph = 'https://api.thegraph.com/subgraphs/name/uniswap/uniswap-v3';

    public function __construct()
    {
        $this->http = new Client(['timeout'=>5.0]);
    }

    /**
     * Fetch all Uniswap v3 positions (NFTs) owned by a user.
     */
    public function getUserPositions(string $userAddress): array
    {
        $query = <<<'GRAPHQL'
        query($user:String!){
          positions(where:{owner:$user}) {
            id
            liquidity
            pool {
              id
              feeTier
              token0 { id symbol decimals }
              token1 { id symbol decimals }
            }
            tickLower { tickIdx }
            tickUpper { tickIdx }
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
        return $data['data']['positions'] ?? [];
    }
}
