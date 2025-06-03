<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{

    SubscriptionController,
    CrybotPlanController,
    WalletController,
    FireblocksController,
    PaymentController
    MarketController,
    OrderBookController,
    TradeController,
    OrderController,
    WalletController,
    CrybotLogController,
    SubscriptionController,
    CrybotPlanController,
    NewsController
};
};

Route::middleware('auth:sanctum')->group(function(){
    // CryBot subscriptions
Route::post('/crybot/subscribe', [SubscriptionController::class,'activate']);
Route::get('/crybot/invite-link', [SubscriptionController::class,'link']);
Route::post('/crybot/update-mode', [SubscriptionController::class,'updateMode']);
    // Plans
Route::get('/crybot/plans', [CrybotPlanController::class,'indexApi']);
    // Wallet deposit / history
Route::get('/wallet/{provider}/address/{asset}', [WalletController::class,'address']);
Route::post('/wallet/fireblocks/address/{asset}', [FireblocksController::class,'address']);
Route::post('/wallet/mtn/charge', [PaymentController::class,'mobileMoneyCharge']);
Route::post('/wallet/mercadopago/checkout', [PaymentController::class,'mpCheckout']);
Route::get('/wallet/deposit-history/{asset}', [WalletController::class,'history']);

Route::prefix('v1')->middleware('auth:sanctum')->group(function(){

    // Market data
Route::get('markets', [MarketController::class,'index']);
Route::get('orderbook', [OrderBookController::class,'index']);      // ?symbol=BTCUSDT
Route::get('trades', [TradeController::class,'index']);            // ?symbol=BTCUSDT&limit=50

    // Trading
Route::post('order', [OrderController::class,'store']);
Route::get('orders', [OrderController::class,'index']);
Route::get('orders/{order}', [OrderController::class,'show']);

    // Wallets
Route::get('wallet/balance', [WalletController::class,'balance']);
Route::get('wallet/address/{provider}/{asset}', [WalletController::class,'address']);
Route::post('wallet/withdraw', [WalletController::class,'withdraw']);
Route::get('wallet/deposit-history/{asset}', [WalletController::class,'history']);

    // CryBot
Route::get('crybot/logs', [CrybotLogController::class,'index']);
Route::get('crybot/plans', [CrybotPlanController::class,'indexApi']);
Route::post('crybot/subscribe', [SubscriptionController::class,'activate']);

    // News & Blog
Route::get('news', [NewsController::class,'index']);
Route::get('news/{id}', [NewsController::class,'show']);
});

// Blog & News
Route::get('blog', [BlogController::class,'index']);
Route::get('blog/{slug}', [BlogController::class,'show']);
Route::get('news', [NewsController::class,'index']);
Route::get('news/{slug}', [NewsController::class,'show']);

// Knowledge Base
Route::get('kb', [KbController::class,'index']);
Route::get('kb/{slug}', [KbController::class,'show']);

// Support Tickets
Route::get('support/tickets', [SupportTicketController::class,'index']);
Route::post('support/tickets', [SupportTicketController::class,'store']);
Route::get('support/tickets/{ticket}', [SupportTicketController::class,'show']);
Route::patch('support/tickets/{ticket}', [SupportTicketController::class,'update']);

// Dispute management
Route::get ('disputes',           [DisputeController::class,'index']);
Route::post('disputes',           [DisputeController::class,'store']);
Route::get ('disputes/{dispute}', [DisputeController::class,'show']);
Route::patch('disputes/{dispute}',[DisputeController::class,'update']); // Admin only

Route::post('chat', [App\Http\Controllers\ChatController::class,'send']);

// AI Chat Support
Route::post('chat', [App\Http\Controllers\ChatController::class, 'send']);

// Escrow
Route::get   ('escrows'                 , [EscrowController::class,'index']);
Route::get   ('escrows/{escrow}'        , [EscrowController::class,'show']);
Route::post  ('escrows/{escrow}/confirm', [EscrowController::class,'confirm']);

// Escrow release
Route::post('p2p/trades/{trade}/release', [P2PEscrowController::class,'release']);
Route::post('p2p/trades/{trade}/dispute', [P2PEscrowController::class,'dispute']);

// backend/routes/api.php

Route::middleware('auth:api')->group(function () {
Route::get('analytics/summary', [AnalyticsController::class, 'summary']);
});

// routes/api.php

Route::middleware('auth:api')->group(function () {
Route::get('analytics/dashboard', [AnalyticsController::class, 'dashboard']);
Route::get('analytics/pairs',     [AnalyticsController::class, 'pairs']);
});

// backend/routes/api.php
Route::middleware('auth:api')->group(function () {
Route::get('spot/order-book/{pair}',      [SpotTradingController::class, 'orderBook']);
Route::post('spot/place-order',           [SpotTradingController::class, 'placeOrder']);
Route::delete('spot/cancel-order/{id}',   [SpotTradingController::class, 'cancelOrder']);
Route::get('spot/my-orders',              [SpotTradingController::class, 'myOrders']);
});

// backend/routes/api.php
Route::middleware('auth:api')->group(function () {
Route::get('futures/positions',           [FuturesController::class, 'positions']);
Route::post('futures/open',               [FuturesController::class, 'open']);
Route::post('futures/close',              [FuturesController::class, 'close']);
Route::get('futures/order-book/{pair}',   [FuturesController::class, 'orderBook']);
});

// backend/routes/api.php
Route::middleware('auth:api')->group(function () {
Route::post('wallet/deposit-notify', [WalletController::class, 'notifyDeposit']);
Route::post('wallet/withdraw-notify',[WalletController::class, 'notifyWithdrawal']);
Route::get('wallet/balances',        [WalletController::class, 'balances']);
});

// backend/routes/api.php
Route::middleware('auth:api')->group(function () {
Route::post('fiat/buy',       [FiatController::class, 'buy']);
Route::post('fiat/sell',      [FiatController::class, 'sell']);
Route::post('fiat/payout',    [FiatController::class, 'payoutCard']);
});

// backend/routes/api.php
Route::middleware('auth:api')->group(function () {
Route::post('crypto/deposit-address',   [CryptoController::class, 'getAddress']);
Route::post('crypto/withdraw',           [CryptoController::class, 'withdraw']);
});

Route::post('compliance/kyc', [ComplianceController::class,'submitKYC']);

// backend/routes/api.php
Route::post('bots/execute', [BotController::class,'execute']);

Route::middleware('auth:api')->get('evm/balance/{chain}/{address}', [EVMController::class,'balance']);

// routes/api.php
Route::middleware('auth:api')->group(function(){
  Route::apiResource('coins','API\CoinController');
  Route::apiResource('markets','API\MarketController');
  Route::apiResource('fees','API\FeeController');
  Route::apiResource('kyc-forms','API\KycFormController');
  Route::apiResource('pages','API\PageController');
  Route::apiResource('plans','API\SubscriptionPlanController');
  Route::apiResource('bot-settings','API\BotSettingController');
  Route::get('markets/overview','API\MarketController@overview');
});

Route::middleware('auth:api')->group(function () {
Route::apiResource('coins',              \App\Http\Controllers\API\CoinController::class);
Route::apiResource('markets',            \App\Http\Controllers\API\MarketController::class);
Route::apiResource('fees',               \App\Http\Controllers\API\FeeController::class);
Route::apiResource('kyc-forms',          \App\Http\Controllers\API\KycFormController::class);
Route::apiResource('pages',              \App\Http\Controllers\API\PageController::class);
Route::apiResource('subscription-plans', \App\Http\Controllers\API\SubscriptionPlanController::class);
Route::apiResource('bot-settings',       \App\Http\Controllers\API\BotSettingController::class);
});

Route::middleware('auth:api')->post('transfer/internal', [\App\Http\Controllers\API\TransferController::class, 'internal']);

Route::middleware('auth:api')->prefix('referral')->group(function(){
Route::get('/', [ReferralController::class,'index']);
Route::post('create', [ReferralController::class,'create']);
Route::post('use', [ReferralController::class,'useCode']);
});
Route::middleware('auth:api')->apiResource('fee-tiers', FeeTierController::class);
Route::middleware('auth:api')->apiResource('api-keys', ApiKeyController::class)->only(['index','store','destroy']);

Route::get('posts', [PostController::class,'index']);
Route::get('posts/{slug}', [PostController::class,'show']);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    DashboardController,
    UserController,
    CoinController,
    OrderController,
    TradeController,
    DepositController,
    WithdrawalController,
    KycController,
    ReferralController,
    FeeTierController,
    ApiKeyController,
    FaqController,
    SettingsController,
    BroadcastController,
    ReportController,
    PostController
};

Route::middleware(['auth:api','role:admin'])->prefix('admin')->group(function(){
    // Dashboard
Route::get('dashboard', [DashboardController::class,'index']);

    // Core resources
Route::apiResource('users',         UserController::class);
Route::apiResource('coins',         CoinController::class);
Route::apiResource('orders',        OrderController::class);
Route::apiResource('trades',        TradeController::class);
Route::apiResource('deposits',      DepositController::class);
Route::apiResource('withdrawals',   WithdrawalController::class);
Route::apiResource('kyc',           KycController::class)->only(['index','show','update']);
Route::apiResource('referrals',     ReferralController::class)->only(['index','store']);
Route::apiResource('fee-tiers',     FeeTierController::class);
Route::apiResource('api-keys',      ApiKeyController::class)->only(['index','store','destroy']);
Route::apiResource('faqs',          FaqController::class);
Route::apiResource('settings',      SettingsController::class);
Route::post('broadcast',            [BroadcastController::class,'send']);
Route::get('reports/{type}',        [ReportController::class,'index']);
Route::get('reports/{type}/download',[ReportController::class,'download']);
Route::apiResource('posts',         PostController::class)->only(['index','show']);
});
Route::get('crypto/deposit-address','API\CryptoController@depositAddress');
Route::post('crypto/withdraw','API\CryptoController@withdraw');

Route::post('swap/quote','API\SwapController@quote');
Route::post('swap','API\SwapController@execute');

Route::get('earn/products', [EarnProductController::class,'index']);
Route::post('earn/products/{id}/subscribe', [EarnProductController::class,'subscribe']);


Route::get('options/chain', [OptionController::class,'chain']);
Route::post('options/quote', [OptionController::class,'quote']);
Route::post('options/order', [OptionController::class,'order']);

Route::get('copy/masters',[MasterTraderController::class,'index']);
Route::post('copy/masters/{id}/follow',[CopyTradeController::class,'follow']);

Route::get('competitions', [CompetitionController::class,'index']);
Route::get('competitions/{id}/leaderboard', [CompetitionController::class,'leaderboard']);

Route::middleware('auth:api')->prefix('user')->group(function(){
Route::get('profile',        [ProfileController::class,'show']);
Route::put('profile',        [ProfileController::class,'update']);
Route::post('avatar',        [ProfileController::class,'updateAvatar']);
});
Route::middleware('auth:api')->group(function(){
Route::get('identity',   [IdentityController::class,'index']);
Route::post('identity',  [IdentityController::class,'upload']);
});
Route::middleware('auth:api')->prefix('crybot')->group(function(){
Route::get('plans',     [CrybotController::class,'plans']);
Route::post('subscribe/{plan}', [CrybotController::class,'subscribe']);
Route::get('signals',   [CrybotController::class,'signals']);
});

Route::post('crybot/mt-config', [CrybotController::class,'downloadMtConfig']);

Route::middleware('auth:api')->get('crybot/e a-download', [CrybotController::class,'downloadEa']);

Route::post('mt/trade-event', [MtController::class,'receiveEvent']);

Route::middleware('auth:api')->group(function(){
Route::post('auth/verify-phone', [AuthController::class,'verifyPhone']);
Route::post('auth/verify-email', [AuthController::class,'verifyEmail']);
});
Route::post('auth/google',[AuthController::class,'google']);
Route::post('auth/apple',[AuthController::class,'apple']);

Route::prefix('admin/settings')->group(function(){
    Route::get('{section}',   [\App\Http\Controllers\Admin\SettingsController::class,'show']);
    Route::put('{section}',   [\App\Http\Controllers\Admin\SettingsController::class,'update']);
});

// under your auth:api group
Route::get('futures/orderbook', [\App\Http\Controllers\API\FuturesController::class,'orderbook']);
Route::post('futures/order',     [\App\Http\Controllers\API\FuturesController::class,'order']);

Route::get('spot/orderbook', [\App\Http\Controllers\API\SpotController::class,'orderbook']);
Route::post('spot/order',    [\App\Http\Controllers\API\SpotController::class,'order']);

// Add to backend/routes/api.php (inside auth:api or public as needed)
Route::get('p2p/offers', [\App\Http\Controllers\API\P2PController::class,'offers']);
Route::post('p2p/order',  [\App\Http\Controllers\API\P2PController::class,'order']);

Route::post('chat', [\App\Http\Controllers\API\ChatbotController::class,'chat']);

Route::get('coinbase/accounts', [\App\Http\Controllers\API\CoinbaseController::class,'accounts']);
Route::post('coinbase/charge',  [\App\Http\Controllers\API\CoinbaseController::class,'charge']);

// Add inside auth:api group
Route::post('user/kyc', [\App\Http\Controllers\API\UserController::class,'uploadKyc']);

// routes/api.php

Route::middleware('auth:api')->group(function () {
    // … other routes …

    // GET /api/v1/user/kyc/download/document
    // GET /api/v1/user/kyc/download/selfie
    Route::get('user/kyc/download/{type}', [\App\Http\Controllers\API\UserController::class, 'downloadKyc'])
        ->where('type', 'document|selfie');
});

// Admin KYC review
Route::middleware(['auth:api','can:admin'])->prefix('admin')->group(function(){
    // List all users pending KYC
    Route::get('kyc/pending', [\App\Http\Controllers\API\Admin\KycController::class,'index']);
    // Approve or reject a user’s KYC
    Route::post('kyc/{user}/status', [\App\Http\Controllers\API\Admin\KycController::class,'updateStatus']);
});

// inside your auth:api + can:admin group
use App\Http\Controllers\API\Admin\UsersController;

Route::get   ('admin/users',        [UsersController::class,'index']);
Route::put   ('admin/users/{user}', [UsersController::class,'update']);
Route::delete('admin/users/{user}', [UsersController::class,'destroy']);

use App\Http\Controllers\API\Admin\CoinController;

Route::apiResource('admin/coins', CoinController::class)
     ->only(['index','store','update','destroy']);

// File: backend/routes/api.php

use App\Http\Controllers\API\Admin\MarketController;

Route::middleware(['auth:api','can:admin'])
     ->apiResource('admin/markets', MarketController::class)
     ->only(['index','store','update','destroy']);

     // Add inside your auth:api + can:admin group in backend/routes/api.php
use App\Http\Controllers\API\Admin\FeeController;

Route::apiResource('admin/fees', FeeController::class)
     ->only(['index','store','update','destroy']);

     // backend/routes/api.php
use App\Http\Controllers\API\Admin\KycFormController;

Route::apiResource('admin/kyc-forms', KycFormController::class)
     ->only(['index','store','update','destroy']);

     // backend/routes/api.php
use App\Http\Controllers\API\Admin\PageController;

Route::apiResource('admin/pages', PageController::class)
     ->only(['index','store','update','destroy']);

     // backend/routes/api.php
use App\Http\Controllers\API\Admin\SubscriptionPlanController;

Route::apiResource('admin/subscription-plans', SubscriptionPlanController::class)
     ->only(['index','store','update','destroy']);

     // backend/routes/api.php
use App\Http\Controllers\API\Admin\BotSettingController;

Route::apiResource('admin/bot-settings', BotSettingController::class)
     ->only(['index','store','update','destroy']);

     // File: backend/routes/api.php

// Public CMS pages
Route::get('pages',          [\App\Http\Controllers\API\PageController::class,'index']);
Route::get('pages/{slug}',   [\App\Http\Controllers\API\PageController::class,'show']);

use App\Http\Controllers\API\ChatController;

Route::post('chat', [ChatController::class, 'chat']);

// File: backend/routes/api.php

Route::post('wallet/withdraw', [\App\Http\Controllers\API\WalletController::class, 'withdraw']);

Route::post('auth/firebase', [\App\Http\Controllers\API\FirebaseAuthController::class,'authenticate']);

use App\Http\Controllers\API\WebauthnController;

Route::middleware('auth:sanctum')->group(function(){
    Route::post('webauthn/register/options',   [WebauthnController::class,'registerOptions']);
    Route::post('webauthn/register/verify',    [WebauthnController::class,'registerVerify']);
});
Route::post('webauthn/authenticate/options', [WebauthnController::class,'authenticateOptions']);
Route::post('webauthn/authenticate/verify',  [WebauthnController::class,'authenticateVerify']);

use App\Http\Controllers\API\{
    MarketController,
    P2POfferController,
    SpotController,
    FuturesController,
    SwapController,
    ReferralController,
    NotificationController
};
use App\Http\Controllers\API\Admin\AnalyticsController;

// Public endpoints
Route::get   ('markets',       [MarketController::class,'index']);
Route::get   ('p2p/offers',    [P2POfferController::class,'index']);
Route::get   ('spot/orderbook',[SpotController::class,'orderbook']);
Route::post  ('spot/order',    [SpotController::class,'order']);
Route::get   ('futures/orderbook',[FuturesController::class,'orderbook']);
Route::post  ('futures/order',   [FuturesController::class,'order']);
Route::get   ('swap/quote',    [SwapController::class,'quote']);
Route::post  ('swap',          [SwapController::class,'swap']);
Route::get   ('pages',         [\App\Http\Controllers\API\PageController::class,'index']);
Route::get   ('pages/{slug}',  [\App\Http\Controllers\API\PageController::class,'show']);
Route::post  ('chat',          [\App\Http\Controllers\API\ChatController::class,'chat']);

// Authenticated user endpoints
Route::middleware('auth:sanctum')->group(function(){
    Route::get('user/referrals', [ReferralController::class,'index']);
    Route::get('notifications',   [NotificationController::class,'index']);
});

// Admin analytics
Route::middleware(['auth:sanctum','can:admin'])->get(
    'admin/settings/analytics-metrics',
    [AnalyticsController::class,'index']
);

use App\Http\Controllers\API\LiquidityController;
use App\Http\Controllers\API\OrderRouterController;

// Liquidity aggregation
Route::get('liquidity/orderbook', [LiquidityController::class,'orderbook']);

// Smart order routing
Route::post('order/smart', [OrderRouterController::class,'execute']);
use App\Http\Controllers\API\OptionsController;

Route::get('options/price', [OptionsController::class,'price']);
use App\Http\Controllers\API\DefiController;

// Aave staking APY
Route::get('defi/staking/apy', [DefiController::class,'stakingApy']);
use App\Http\Controllers\API\DefiUserController;

Route::middleware('auth:sanctum')->group(function(){
    Route::get('defi/aave/positions', [DefiUserController::class,'positions']);
});
Route::get('defi/aave/config', [DefiUserController::class,'config']);
use App\Http\Controllers\API\CompoundController;

Route::middleware('auth:sanctum')->group(function(){
    Route::get('defi/compound/positions', [CompoundController::class,'positions']);
});
Route::get('defi/compound/config', [CompoundController::class,'config']);
use App\Http\Controllers\API\YearnController;

Route::middleware('auth:sanctum')->group(function(){
    Route::get('defi/yearn/positions', [YearnController::class,'positions']);
});
Route::get('defi/yearn/config', [YearnController::class,'config']);
use App\Http\Controllers\API\UniswapController;

Route::middleware('auth:sanctum')->get(
    'defi/uniswap/positions',
    [UniswapController::class,'positions']
);
Route::get(
    'defi/uniswap/config',
    [UniswapController::class,'config']
);
use App\Http\Controllers\API\BridgeController;

Route::get('defi/bridge/quote', [BridgeController::class,'quote']);
// File: backend/routes/api.php

use App\Http\Controllers\API\ChainlinkController;

Route::get('chainlink/feeds', [ChainlinkController::class, 'feeds']);

use App\Http\Controllers\API\NftController;

Route::get('nft/config',      [NftController::class,'config']);
Route::get('nft/marketplace', [NftController::class,'marketplace']);

use App\Http\Controllers\API\TaxController;

Route::middleware('auth:sanctum')->get(
    'tax/report',
    [TaxController::class,'report']
);

Route::middleware(['auth:sanctum','role:admin'])->group(function(){
    // all admin-only endpoints
    Route::get('admin/settings/analytics-metrics', ...);
    // ...
});
use App\Http\Controllers\API\AnalyticsController;

// User endpoints
Route::middleware('auth:sanctum')->group(function(){
    Route::get('analytics/risk',    [AnalyticsController::class,'risk']);
    Route::get('analytics/signals', [AnalyticsController::class,'signals']);
    Route::get('analytics/fraud',   [AnalyticsController::class,'fraud']);
});
use Jimdo\Prometheus\RenderTextFormat;
use Jimdo\Prometheus\CollectorRegistry;

Route::get('/metrics', function(RenderTextFormat $renderer, CollectorRegistry $registry) {
    $metrics = $registry->getMetricFamilySamples();
    return response($renderer->render($metrics), 200)
          ->header('Content-Type', RenderTextFormat::MIME_TYPE);
});
use App\Http\Controllers\API\DerivativesController;

Route::get('futures/orderbook', [DerivativesController::class,'orderbook']);
Route::get('futures/stats',     [DerivativesController::class,'stats']);

use App\Http\Controllers\API\DeFiController;

Route::get('defi/aave',     [DeFiController::class,'aave']);
Route::get('defi/compound', [DeFiController::class,'compound']);
use App\Http\Controllers\API\ChainlinkController;

Route::get('chainlink/price',  [ChainlinkController::class,'price']);
Route::get('chainlink/prices', [ChainlinkController::class,'prices']);
use App\Http\Controllers\API\NewsController;
Route::get('news', [NewsController::class,'index']);

use App\Http\Controllers\API\OptionsController;
use App\Http\Controllers\API\StocksController;

Route::get('options/data', [OptionsController::class, 'data']);
Route::get('stocks/data',  [StocksController::class, 'data']);
