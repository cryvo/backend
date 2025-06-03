<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class NftController extends Controller
{
    protected Client $http;
    protected array  $cfg;

    public function __construct()
    {
        $this->http = new Client([
            'timeout' => 5.0,
            'headers' => array_filter([
              'X-API-KEY' => config('services.nft.opensea_api_key') ?: null,
            ]),
        ]);
        $this->cfg  = config('services.nft');
    }

    /**
     * GET /api/v1/nft/config
     */
    public function config()
    {
        return response()->json([
          'contract'        => $this->cfg['contract'],
          'collection_slug' => $this->cfg['collection_slug'],
        ]);
    }

    /**
     * GET /api/v1/nft/marketplace
     * Proxies to OpenSea’s assets endpoint
     */
    public function marketplace(Request $r)
    {
        $slug = $this->cfg['collection_slug'];
        $res = $this->http->get('https://api.opensea.io/api/v1/assets', [
          'query' => [
            'collection_slug' => $slug,
            'limit'           => 20,
            'order_direction' => 'desc',
          ],
        ]);
        return response($res->getBody(), 200)
               ->header('Content-Type', 'application/json');
    }
}
