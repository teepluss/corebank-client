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
     * The api endpoint.
     *
     * @var string
     */
    protected $endpoint = 'http://codeinvader.com/api';

    /**
     * Endpoint to issue token.
     *
     * @var string
     */
    protected $issueTokenEndpoint = 'http://codeinvader.com/oauth';

    /**
     * Api config.
     *
     * @var string
     */
    protected $config;

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

        if (isset($config['endpoint']) && ! empty($config['endpoint'])) {
            $this->endpoint = $config['endpoint'];
        }

        $parseUrl = parse_url($this->endpoint);
        $this->issueTokenEndpoint = $parseUrl['scheme'].'://'.$parseUrl['host'].'/oauth';

        $this->config = $config;

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
     * Request token using username and password.
     *
     * @param  string $username
     * @param  string $password
     * @return array
     */
    public function requestGrantTypePasswordToken($username, $password)
    {
        $response = $this->client->request('POST', $this->issueTokenEndpoint.'/token', [
            'form_params' => [
                'client_id' => $this->config['app_id'],
                'client_secret' => $this->config['secret'],
                'grant_type' => 'password',
                'username' => $username,
                'password' => $password,
            ]
        ]);

        $content = $response->getBody();

        return json_decode($content);
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
