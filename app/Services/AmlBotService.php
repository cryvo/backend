<?php
// app/Services/AmlBotService.php
namespace App\Services;

use GuzzleHttp\Client;

class AmlBotService
{
    protected $client;
    public function __construct() {
      $this->client = new Client([
        'base_uri'=>'https://api.amlbot.com/v1/',
        'headers'=>['Authorization'=>'Bearer '.config('services.amlbot.key')]
      ]);
    }

    public function screen($userData)
    {
      $res = $this->client->post('screening', ['json'=>$userData]);
      return json_decode($res->getBody(), true);
    }
}
