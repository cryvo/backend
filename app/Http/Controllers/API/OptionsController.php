<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class StocksService
{
    /**
     * Fetch recent stock volume data for an underlying symbol.
     * Stubbed with random data; replace with real API (e.g. AlphaVantage).
     */
    public function getStockData(string $symbol): array
    {
        $data = [];
        for ($i = 30; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $data[] = [
                'date'   => $date,
                'volume' => rand(1000000, 10000000),
            ];
        }
        return $data;
    }
}
