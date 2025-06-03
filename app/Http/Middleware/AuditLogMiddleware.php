<?php
namespace App\Services;

use Aws\Kms\KmsClient;

class KmsService
{
    protected KmsClient $client;

    public function __construct()
    {
        $this->client = new KmsClient([
            'region'      => config('services.kms.region'),
            'version'     => 'latest',
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
    }

    /**
     * Sign a payload via KMS (HSM-backed).
     */
    public function sign(string $message): string
    {
        $result = $this->client->sign([
            'KeyId'            => config('services.kms.key_id'),
            'Message'          => $message,
            'MessageType'      => 'RAW',
            'SigningAlgorithm' => 'RSASSA_PKCS1_V1_5_SHA_256',
        ]);
        return base64_encode($result['Signature']);
    }
}
