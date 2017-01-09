<?php

namespace Teepluss\Corebank;

use Closure;
use GuzzleHttp;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class Corebank
{
    protected $client;

    protected $endpoint;

    protected $timeout = 30;

    public function __construct($config)
    {
        $this->client = new GuzzleHttp\Client();

        $this->endpoint = $config['endpoint'];

        return $this;
    }

    /**
     * Post transactions to corebank.
     *
     * @param  array $transactions
     * @return array
     */
    // public function createTransactions($transactions)
    // {
    //     $response = $this->api('POST', '/transactions', [
    //         'json' => $transactions
    //     ]);

    //     return $response;
    // }

    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function api($method = 'GET', $path, array $formParams = [])
    {
        $method = strtoupper($method);
        $path = ltrim($path, '/');

        $endpoint = $this->endpoint.'/'.$path;

        $parameters = [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json',
            ],
            'timeout' => $this->timeout
        ];

        if (in_array($method, ['POST', 'PUT', 'PATCH'])) {
            $data = [
                'form_params' => $formParams
            ];
            $parameters = array_merge($parameters, $data);

        }
        
        $response = $this->client->request($method, $endpoint, $parameters);
    
        return $response;
    }
}
