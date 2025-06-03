<?php
// File: backend/app/Services/ChatbotService.php

namespace App\Services;

use OpenAI;

/**
 * ChatbotService integrates with OpenAI GPT to power C.V.A. (Cryvo Virtual Assistant).
 * It uses a detailed system prompt to ensure the assistant can answer any question
 * related to the entire Cryvo platform and Crybot features end-to-end.
 */
class ChatbotService
{
    protected $client;

    public function __construct()
    {
        // Initialize OpenAI client using the configured API key
        $this->client = OpenAI::client(config('services.openai.key'));
    }

    /**
     * Ask C.V.A. a question and return its reply.
     *
     * @param string $msg The user's message/question.
     * @return string The assistant's answer.
     */
    public function ask(string $msg): string
    {
        $response = $this->client->chat()->create([
            'model'    => 'gpt-4',
            'messages' => [
                [
                    'role'    => 'system',
                    'content' => <<<EOD
You are C.V.A., the Cryvo Virtual Assistant. You have complete knowledge of the Cryvo platform—a global crypto exchange allowing users to trade crypto to fiat and fiat for crypto across spot, futures, P2P, swap, earn, options, copy-trading, and competitions. You also deeply understand Crybot: how to subscribe, download and configure the MT4/5 EA, set up scalping or regular auto-trading modes, configure lot-sizing, filters (EMA, Heikin-Ashi), and risk parameters. Additionally, you have full access to the Cryvo FAQ covering account setup, KYC, security, wallets, notifications, API integrations, and admin settings. Provide clear, concise, and accurate answers to user inquiries regarding any aspect of Cryvo or Crybot.
EOD
                ],
                [
                    'role'    => 'user',
                    'content' => $msg
                ],
            ],
        ]);

        return trim($response['choices'][0]['message']['content'] ?? '');
    }
}
'coinbase' => [
  'key'       => env('COINBASE_API_KEY'),
  'secret'    => env('COINBASE_API_SECRET'),
  'passphrase'=> env('COINBASE_API_PASSPHRASE'),
],
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | OpenAI (C.V.A. Chatbot)
    |--------------------------------------------------------------------------
    |
    | API key for OpenAI GPT that powers the Cryvo Virtual Assistant.
    |
    */
    'openai' => [
        'key' => env('OPENAI_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Crybot Engine
    |--------------------------------------------------------------------------
    |
    | URL of the Crybot scanning engine service (for runScan HTTP calls).
    |
    */
    'crybot' => [
        'engine_url' => env('CRYBOT_ENGINE_URL', 'http://localhost:3001'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Coinbase Commerce
    |--------------------------------------------------------------------------
    |
    | Credentials for Coinbase Commerce on‐ramp/off‐ramp integration.
    |
    */
    'coinbase' => [
        'key'        => env('COINBASE_API_KEY'),
        'secret'     => env('COINBASE_API_SECRET'),
        'passphrase' => env('COINBASE_API_PASSPHRASE'),
    ],

];
 
// File: config/services.php

return [
    // … other services …

    /*
    |--------------------------------------------------------------------------
    | Chainlink Price Feeds
    |--------------------------------------------------------------------------
    |
    | On-chain AggregatorV3Interface addresses for your supported pairs.
    |
    */
    'chainlink' => [
        'feeds' => [
            'ETH/USD' => '0x5f4ec3df9cbd43714fe2740f5e3616155c5b8419',
            'BTC/USD' => '0xf4030086522a5beea4988f8ca5b36dbc97bee88',
            // add more pair => aggregatorAddress as needed
        ],
    ],
];
// File: config/services.php

return [
    // … other services …

    /*
    |--------------------------------------------------------------------------
    | NFT Marketplace & Launchpad
    |--------------------------------------------------------------------------
    */
    'nft' => [
        // your ERC-721 launchpad contract
        'contract'         => env('NFT_CONTRACT_ADDRESS'),
        // for marketplace listings via OpenSea
        'collection_slug'  => env('NFT_COLLECTION_SLUG'),
    ],
];
    /*
    |--------------------------------------------------------------------------
    | AML / Sanctions Screening (Chainalysis)
    |--------------------------------------------------------------------------
    |
    */
    'chainalysis' => [
        'base_url' => env('CHAINALYSIS_URL', 'https://api.chainalysis.com'),
        'api_key'  => env('CHAINALYSIS_API_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Tax Reporting (Koinly)
    |--------------------------------------------------------------------------
    */
    'koinly' => [
        'api_key' => env('KOINLY_API_KEY'),
    ],
/*
|--------------------------------------------------------------------------
| AWS KMS (for HSM-backed keys)
|--------------------------------------------------------------------------
*/
'kms' => [
    'key_id' => env('AWS_KMS_KEY_ID'),
    'region' => env('AWS_DEFAULT_REGION'),
],
// File: config/services.php

return [
    // … other services …

    /*
    |--------------------------------------------------------------------------
    | DeFi Integrations
    |--------------------------------------------------------------------------
    */
    'defi' => [
        'rpc_url'      => env('DEFIPROVIDER_RPC_URL'),
        'aave' => [
            'lendingPoolAddress' => env('AAVE_LENDING_POOL'),
        ],
        'compound' => [
            'cTokens' => [
                'DAI' => '0x5d3a536E4D6DbD6114cc1Ead35777bAB948E3643',
                'USDC'=> '0x39AA39c021dfbaE8faC545936693aC917d5E7563',
                // add more cTokens
            ],
        ],
    ],
];
'chainlink' => [
  'api_base'    => env('CHAINLINK_API_BASE', 'https://api.chain.link'),
  'aggregators' => [
    'BTC_USD' => '0xF4030086522a5bEEa4988F8cA5B36dbC97BeE88c',
    'ETH_USD' => '0x5f4eC3Df9cbd43714FE2740f5E3616155c5b8419',
    // ...add more...
  ],
],
