<?php

namespace App\Htpp;

use Symfony\Contracts\HttpClient\HttpClientInterface;

use Http\BL\BricklinkAPI;

class HttpHandle
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchBrickLinkInventory()
    {
        $BricklinkApi = new BricklinkAPI([
            'consumerKey' => '',
            'consumerSecret' => '',
            'tokenValue' => '',
            'tokenSecrect' => ''
        ]);   
        $response = $BricklinkApi->request('GET', '/inventories')
                    ->execute()->getRawResponse();

        return $response;
    }
}