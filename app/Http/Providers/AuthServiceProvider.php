<?php
namespace App\Providers;

use App\Models\{User,Coin,Order,Trade,Deposit,Withdrawal,Kyc,Referral,FeeTier,ApiKey,Faq,Setting,Post};
use App\Policies\{UserPolicy,CoinPolicy,OrderPolicy,TradePolicy,DepositPolicy,WithdrawalPolicy,KycPolicy,ReferralPolicy,FeeTierPolicy,ApiKeyPolicy,FaqPolicy,SettingPolicy,PostPolicy};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class       => UserPolicy::class,
        Coin::class       => CoinPolicy::class,
        Order::class      => OrderPolicy::class,
        Trade::class      => TradePolicy::class,
        Deposit::class    => DepositPolicy::class,
        Withdrawal::class => WithdrawalPolicy::class,
        Kyc::class        => KycPolicy::class,
        Referral::class   => ReferralPolicy::class,
        FeeTier::class    => FeeTierPolicy::class,
        ApiKey::class     => ApiKeyPolicy::class,
        Faq::class        => FaqPolicy::class,
        Setting::class    => SettingPolicy::class,
        Post::class       => PostPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
