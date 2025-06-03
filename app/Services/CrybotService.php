<?php
namespace App\Services;

use App\Models\CrybotSubscription;
use App\Models\CrybotSignal;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CrybotService
{
    protected $engineUrl;

    public function __construct()
    {
        $this->engineUrl = config('services.crybot.engine_url');
    }

    /**
     * Scan active subscriptions, generate entry signals, apply filters,
     * store & dispatch only those passing all filters.
     */
    public function runScan()
    {
        CrybotSubscription::where('status', 'active')->get()->each(function($sub) {
            $plan = $sub->plan;
            $mode = $plan->features['auto_trade_mode'] ?? 'regular';

            // Select primary strategies based on mode
            $strategies = $mode === 'scalping'
                ? ($plan->features['scalping_strategies'] ?? [])
                : ($plan->features['regular_strategies']  ?? []);

            // 1) Gather raw entry signals
            $rawSignals = [];
            foreach ($strategies as $strat) {
                $method = 'scan' . Str::studly($strat);
                if (method_exists($this, $method)) {
                    $rawSignals = array_merge($rawSignals, $this->$method($plan->features));
                }
            }

            // 2) Gather confirm filters if any
            $filters = $plan->features['filters'] ?? [];
            $filterMarkets = null;
            foreach ($filters as $f) {
                $m = [];
                $fm = 'scan' . Str::studly($f);
                if (method_exists($this, $fm)) {
                    $fsigs = $this->$fm($plan->features);
                    $m = array_column($fsigs, 'market');
                }
                $filterMarkets = $filterMarkets === null ? $m : array_intersect($filterMarkets, $m);
            }

            // 3) Filter rawSignals by those markets that pass all filters
            $allSignals = $filterMarkets === null
                ? $rawSignals
                : array_filter($rawSignals, fn($s) => in_array($s['market'], $filterMarkets));

            // 4) Persist & dispatch
            foreach ($allSignals as $sig) {
                $signal = CrybotSignal::create([
                    'subscription_id' => $sub->id,
                    'market'          => $sig['market'],
                    'type'            => $sig['type'],
                    'side'            => $sig['side'],
                    'price'           => $sig['price'],
                    'sent_at'         => now(),
                ]);

                app()->make(\App\Services\NotificationService::class)
                     ->sendCrybotSignal($sub->user, $signal);
            }
        });
    }

    // Primary Strategies
    protected function scanIchimoku(array $f): array
    {
        return Http::post("{$this->engineUrl}/scan/ichimoku", [
            'params' => $f['ichimoku'] ?? []
        ])->json('signals') ?? [];
    }

    protected function scanRsiDivergence(array $f): array
    {
        return Http::post("{$this->engineUrl}/scan/rsi-divergence", [
            'period' => $f['rsi_period'] ?? 14
        ])->json('signals') ?? [];
    }

    protected function scanBollingerBreaks(array $f): array
    {
        return Http::post("{$this->engineUrl}/scan/bollinger", [
            'multiplier' => $f['bollinger_mult'] ?? 2
        ])->json('signals') ?? [];
    }

    protected function scanVwapBounce(array $f): array
    {
        return Http::post("{$this->engineUrl}/scan/vwap-bounce", [])->json('signals') ?? [];
    }

    protected function scanFiboConfluence(array $f): array
    {
        return Http::post("{$this->engineUrl}/scan/fibo", [
            'levels' => $f['fibo_levels'] ?? [0.382, 0.618]
        ])->json('signals') ?? [];
    }

    protected function scanMlModel(array $f): array
    {
        return Http::post("{$this->engineUrl}/scan/mlmodel", [
            'model' => $f['ml_model'] ?? 'default'
        ])->json('signals') ?? [];
    }

    // Confirm Filters
    protected function scanHeikinAshi(array $f): array
    {
        return Http::post("{$this->engineUrl}/scan/heikin-ashi", [
            'periods' => $f['heikin_periods'] ?? [5, 10]
        ])->json('signals') ?? [];
    }

    protected function scanEmaCross(array $f): array
    {
        return Http::post("{$this->engineUrl}/scan/ema-cross", [
            'fast' => $f['ema_fast'] ?? 20,
            'slow' => $f['ema_slow'] ?? 100,
        ])->json('signals') ?? [];
    }
}
