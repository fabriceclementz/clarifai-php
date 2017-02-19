<?php

namespace Fab\Clarifai;

use GuzzleHttp\Client as HttpClient;

class Client
{
    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * The Clarifai client id.
     * @var string
     */
    protected $clientId;

    /**
     * The Clarifai client secret.
     * @var string
     */
    protected $clientSecret;

    /**
     * The Clarifai access token.
     * @var string
     */
    protected $accessToken;

    /**
     * The Clarifai API base URL.
     * @var string
     */
    protected $baseUrl = 'https://api.clarifai.com/v2';

    /**
     * Instantiate a new clarifai client.
     *
     * @param HttpClient $client
     * @param string $clientId
     * @param string $clientSecret
     */
    public function __construct($client, $clientId, $clientSecret)
    {
        $this->client = $client;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function withAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Predict the content of an image using the Clarifai API.
     *
     * @param  array  $urls
     * @param  string $modelId
     * @return array
     */
    public function predict(array $urls, $modelId = Models::GENERAL)
    {
        $body = [];

        foreach ($urls as $url) {
            $body['inputs'][] = Input::fromUrl($url)->format();
        }

        $response = $this->client->request('POST', $this->baseUrl.'/models/'.$modelId.'/outputs', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->accessToken,
            ],
            'json' => $body,
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Retrieve a new access token.
     *
     * @return array
     */
    public function accessToken()
    {
        $response = $this->client->request('POST', $this->baseUrl . '/token', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'auth' => [$this->clientId, $this->clientSecret],
        ]);

        return json_decode($response->getBody(), true);
    }
}
