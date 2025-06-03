<?php
namespace App\Services;

class OrderRouterService
{
    protected LiquidityService $liq;
    protected Client $http;

    public function __construct(LiquidityService $liq)
    {
        $this->liq  = $liq;
        $this->http = new \GuzzleHttp\Client(['timeout'=>2.0]);
    }

    /**
     * Execute a smart route: choose best venue & place order.
     *
     * @param  array{symbol:string,side:string,amount:float}  $data
     * @return array
     */
    public function routeOrder(array $data): array
    {
        $symbol = $data['symbol'];
        $side   = $data['side'];    // buy or sell
        $amount = $data['amount'];

        // 1) get aggregated book
        $book = $this->liq->getAggregatedOrderBook($symbol);
        $entries = $side==='buy' ? $book['asks'] : $book['bids'];

        // 2) pick best price
        $best = $entries[0] ?? null;
        if (! $best) {
            throw new \Exception('No liquidity available');
        }
        [$price, $avail] = $best;

        // 3) decide venue: if best came from Binance or Coinbase?
        //    Here we simply route all buys < market to Binance and others to Coinbase
        $venue = $price <= $book['asks'][0][0] ? 'binance' : 'coinbase';

        // 4) send order to that REST API
        if ($venue==='binance') {
            $path = 'https://api.binance.com/api/v3/order';
            $params = [
                'symbol'=>str_replace('_','',$symbol),
                'side'=>strtoupper($side),
                'type'=>'LIMIT',
                'price'=>$price,
                'quantity'=>$amount,
                'timeInForce'=>'GTC'
            ];
            $res = $this->http->post($path,['json'=>$params])->getBody();
        } else {
            // Coinbase Pro
            $path = "https://api.exchange.coinbase.com/orders";
            $params = [
                'product_id'=>str_replace('_','-',$symbol),
                'side'=>$side,
                'type'=>'limit',
                'price'=>strval($price),
                'size'=>strval($amount),
                'time_in_force'=>'GTC'
            ];
            $res = $this->http->post($path,['json'=>$params])->getBody();
        }

        return json_decode($res, true);
    }
}
