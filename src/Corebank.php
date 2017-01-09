<?php

namespace Teepluss\Corebank;

use Closure;
use GuzzleHttp;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class Corebank
{
    /**
     * Guzzle client.
     * 
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Api endpoint.
     * 
     * @var string
     */
    protected $endpoint;

    /**
     * Request timeout.
     * 
     * @var integer
     */
    protected $timeout = 30;

    /**
     * Access token.
     * 
     * @var string
     */
    protected $accessToken;

    /**
     * Request headers.
     * 
     * @var array
     */
    protected $headers = [
        'Content-Type' => 'application/x-www-form-urlencoded',
        'Accept' => 'application/json'
    ];

    /**
     * Construct.
     * 
     * @param array $config 
     */
    public function __construct($config)
    {
        $this->client = new GuzzleHttp\Client();

        $this->endpoint = $config['endpoint'];

        return $this;
    }

    /**
     * Set access token.
     */
    public function setAccessToken($token)
    {
        $this->accessToken = $token;

        $this->headers = array_merge($this->headers, [
            'Authorization' => 'Bearer '.$token
        ]);

        return $this;
    }

    /**
     * Return access token.
     * 
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set Timeput.
     * 
     * @param integer $timeout 
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Set headers.
     * 
     * @param array $headers 
     */
    public function setHeaders($headers = [])
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    /**
     * Set a header.
     * 
     * @param string $key   
     * @param stainr $value 
     */
    public function setHeader($key, $value) 
    {
        $this->setHeaders([$key => $value]);

        return $this;
    }

    /**
     * Make request.
     * 
     * @param  string $method     
     * @param  string $path       
     * @param  array  $formParams 
     * @return \GuzzleHttp\Psr7\Response          
     */
    public function api($method = 'GET', $path, array $formParams = [])
    {
        $method = strtoupper($method);
        $path = ltrim($path, '/');

        $endpoint = $this->endpoint.'/'.$path;
        $headers = $this->headers;

        $parameters = [
            'headers' => $headers,
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
