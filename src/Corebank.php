<?php

namespace Teepluss\Corebank\Corebank;

use Closure;
use GuzzleHttp;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class Corebank
{
    protected $client;

    protected $endpoint;

    protected $timeout = 30;

    protected $response = ['success', 'error'];

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
    public function createTransactions($transactions)
    {
        $response = $this->request('POST', '/transactions', [
            'json' => $transactions
        ]);

        return $response;
    }

    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    protected function request($method = 'GET', $path, array $data = [])
    {
        $method = strtoupper($method);
        $path = rtrim($path, '/');

        $endpoint = $this->endpoint.'/'.$path;

        $parameters = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'timeout' => $this->timeout
        ];

        if (in_array($method, ['POST', 'PUT', 'PATCH'])) {
            $parameters = array_merge($parameters, $data);
        }

        try {
            $response = $this->client->request($method, $endpoint, $parameters);
            $data = $response->getBody();
            $this->response['success'] = json_decode($data, true);
        } catch (RequestException $e) {
            // echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                $data = $e->getResponse()->getBody();
                $this->response['error'] = json_decode($data, true);
            }
        }

        return $this;
    }

    function then(Closure $success, Closure $error)
    {
        $success(array_get($this->response, 'success'));
        $error(array_get($this->response, 'error'));

        return $this;
    }
}
