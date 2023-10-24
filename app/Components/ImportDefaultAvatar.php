<?php

namespace App\Components;

use GuzzleHttp\Client;

class ImportDefaultAvatar {

    public $client;

    public function __construct()
    {
        $this->client = new Client([
             //Base URI is used with relative requests
             'base_uri' => 'https://api.dicebear.com/7.x/fun-emoji/svg',
             'timeout' => '2.0',
             'verify' => false,
        ]);
    }
}
