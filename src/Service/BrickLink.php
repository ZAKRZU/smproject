<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class BrickLink
{

    private $client;
    private $headers;
    private $consumerSecret;
    private $tokenSecret;
    private $endpoint;
    private $params;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        $this->consumerSecret = $_ENV['CONSUMER_SECRET'];
        $this->tokenSecret = $_ENV['TOKEN_SECRET'];
        $this->endpoint = 'https://api.bricklink.com/api/store/v1';
        $this->params = [];
        $this->generatetHeaders();
    }

    public function getInventories(): array
    {
        // $this->generateSignature('GET', '/inventories');

        // $path = 'https://api.bricklink.com/api/store/v1/inventories?Authorization='.$this->askJson('GET', '/inventories');

        $response = $this->client->request(
            'GET',
            $this->generateUrl('GET', '/inventories'),
            // 'https://api.bricklink.com/api/store/v1/inventories',
            // ['headers' => $this->headers]
        );

        // $statusCode = $response->getStatusCode();

        // $contentType = $response->getHeaders()['content-type'][0];

        // $content = $response->getContent();

        $content = $response->toArray();

        return $content;
    }

    public function getInventory(int $id): array
    {
        $path = '/inventories/'.$id.'/';

        $response = $this->client->request(
            'GET',
            $this->generateUrl('GET', $path),
        );

        $content = $response->toArray();

        return $content;
    }

    public function getItem(string $type, string $no): array
    {
        $path = '/items/'.$type.'/'.$no;

        $response = $this->client->request(
            'GET',
            $this->generateUrl('GET', $path),
        );

        $content = $response->toArray();

        return $content;
    }

    public function getItemImage(string $type, string $no, int $colorId): array
    {
        $path = '/items/'.$type.'/'.$no.'/images/'.$colorId;

        $response = $this->client->request(
            'GET',
            $this->generateUrl('GET', $path),
        );

        $content = $response->toArray();

        return $content;
    }

    private function generateSignature(String $method, String $path)
    {
        $this->generatetHeaders();
        $parameters = $this->headers;
        if ($method == 'GET')
        {
            $parameters = array_merge($parameters, $this->params);
        }
        ksort($parameters);
        $paramterString = http_build_query($parameters);

        $signature_basestring = $method.'&'.rawurlencode($this->endpoint.$path).'&'.rawurlencode($paramterString);
        $secretString = $this->consumerSecret.'&'.$this->tokenSecret;
        $signature = base64_encode(hash_hmac('sha1', $signature_basestring, $secretString, true));

        return $signature;
    }

    private function generateUrl(String $method, String $path)
    {
        $this->headers['oauth_signature'] = $this->generateSignature($method, $path);

        $jsonAuthorization = json_encode($this->headers);
        if ($method == 'GET' && count($this->params))
        {
            $url = $this->endpoint.$path.'?'.http_build_query($this->params).'&Authorization='.rawurlencode($jsonAuthorization);
        } 
        else 
        {
            $url = $this->endpoint.$path.'?Authorization='.rawurlencode($jsonAuthorization);
        }
        return $url;
    }

    private function generatetHeaders(){
        $this->headers = [
            'oauth_consumer_key' => $_ENV['CONSUMER_KEY'],
            'oauth_nonce' => substr( md5(rand()), 0, 7),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_signature' => null,
            'oauth_timestamp' => (string) time(),
            'oauth_token' => $_ENV['TOKEN_VALUE'],
            'oauth_version' => '1.0',
        ];
    }


}
