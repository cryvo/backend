<?php
// app/Services/VeriffService.php
namespace App\Services;

use GuzzleHttp\Client;

class VeriffService
{
    protected $client;
    public function __construct() {
      $this->client = new Client([
        'base_uri'=>'https://stationapi.veriff.com/v1/',
        'headers'=>[
          'X-AUTH-CLIENT'=>config('services.veriff.api_key'),
          'Accept'=>'application/json',
        ]
      ]);
    }

    public function createSession($userId, $callbackUrl)
    {
      $res = $this->client->post('sessions', [
        'json'=>[
          'verification'=>[
            'callback'=>'https://cryvo.io'.$callbackUrl,
            'person'=>['id'=>$userId],
          ]
        ]
      ]);
      return json_decode($res->getBody(), true);
    }
}
