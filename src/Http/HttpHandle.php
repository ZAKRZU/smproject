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
            'consumerKey' => $_ENV['CONSUMER_KEY'],
            'consumerSecret' => $_ENV['CONSUMER_SECRET'],
            'tokenValue' => $_ENV['TOKEN_VALUE'],
            'tokenSecret' => $_ENV['TOKEN_SECRET']
        ]);   
        $response = $BricklinkApi->request('GET', '/inventories')
                    ->execute()->getRawResponse();

        return $response;
    }
}