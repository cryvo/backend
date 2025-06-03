<?php
// File: backend/app/Services/YearnService.php
namespace App\Services;

use GuzzleHttp\Client;

class YearnService
{
    protected Client $http;
    protected string $subgraph = 'https://api.thegraph.com/subgraphs/name/yearn/yearn-vaults-v2';

    public function __construct()
    {
        $this->http = new Client(['timeout'=>5.0]);
    }

    /**
     * Get user vault shares.
     */
    public function getUserVaults(string $userAddress): array
    {
        $query = <<<'GRAPHQL'
        query($user:String!){
          user(id:$user) {
            shares {
              vault {
                id
                symbol
                name
              }
              balance
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
        return $data['data']['user']['shares'] ?? [];
    }
}
