<?php

namespace Fab\Clarifai\Tests;

use Fab\Clarifai\Client;
use Fab\Clarifai\Models;
use GuzzleHttp\Client as HttpClient;
use Mockery;

class ClientTest extends TestCase
{
    /** @test */
    function can_instantiate_client()
    {
        $httpClient = $this->getHttpClientMock();

        $client = new Client($httpClient, 'client-id', 'client-secret');

        $this->assertInstanceOf(Client::class, $client);
    }

    /** @test */
    function can_retrieve_an_access_token()
    {
        $httpClient = $this->getHttpClientMock();
        $httpClient
            ->shouldReceive('request')
            ->with('POST', 'https://api.clarifai.com/v2/token', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'auth' => ['client-id', 'client-secret'],
            ])
            ->andReturn($httpClient);

            $httpClient
                ->shouldReceive('getBody')
                ->andReturn(json_encode(['foo' => 'bar']));

        $client = new Client($httpClient, 'client-id', 'client-secret');

        $response = $client->accessToken();

        $this->assertEquals(['foo' => 'bar'], $response);
    }

    /** @test */
    function can_predict_the_content_of_an_image_by_passing_an_url()
    {
        $httpClient = $this->sendRequest(
            $this->getHttpClientMock(),
            'https://api.clarifai.com/v2/models/aaa03c23b3724a16a56b629203edc62c/outputs',
            [
                [
                    'data' => [
                        'image' => [
                            'url' => 'https://samples.clarifai.com/metro-north.jpg',
                        ]
                    ]
                ]
            ]
        );

        $client = new Client($httpClient, 'client-id', 'client-secret');

        $response = $client->withAccessToken('access-token')->predict([
            'https://samples.clarifai.com/metro-north.jpg',
        ]);

        $this->assertTrue(is_array($response));
        $this->assertEquals([
            'foo' => 'bar'
        ], $response);
    }

    /** @test */
    function use_general_model_by_default_when_predicting_the_content_of_an_image()
    {
        $httpClient = $this->sendRequest(
            $this->getHttpClientMock(),
            'https://api.clarifai.com/v2/models/'.Models::GENERAL.'/outputs',
            [
                [
                    'data' => [
                        'image' => [
                            'url' => 'https://samples.clarifai.com/metro-north.jpg',
                        ]
                    ]
                ]
            ]
        );

        $client = new Client($httpClient, 'client-id', 'client-secret');

        $response = $client->withAccessToken('access-token')->predict([
            'https://samples.clarifai.com/metro-north.jpg',
        ]);

        $this->assertTrue(is_array($response));
        $this->assertEquals([
            'foo' => 'bar'
        ], $response);
    }

    /** @test */
    function can_predict_the_content_of_an_image_by_passing_an_url_and_a_specific_model()
    {
        $httpClient = $this->sendRequest(
            $this->getHttpClientMock(),
            'https://api.clarifai.com/v2/models/'.Models::FOOD.'/outputs',
            [
                [
                    'data' => [
                        'image' => [
                            'url' => 'https://samples.clarifai.com/metro-north.jpg',
                        ]
                    ]
                ]
            ]
        );

        $client = new Client($httpClient, 'client-id', 'client-secret');

        $response = $client->withAccessToken('access-token')->predict([
            'https://samples.clarifai.com/metro-north.jpg',
        ], Models::FOOD);

        $this->assertTrue(is_array($response));
        $this->assertEquals([
            'foo' => 'bar'
        ], $response);
    }

    private function getHttpClientMock()
    {
        return Mockery::mock(HttpClient::class);
    }

    private function sendRequest($httpClient, $url, $inputs)
    {
        $httpClient
            ->shouldReceive('request')
            ->with('POST', $url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer access-token',
                ],
                'json' => [
                    'inputs' => $inputs
                ]
            ])
            ->andReturn($httpClient);

        $httpClient
            ->shouldReceive('getBody')
            ->andReturn(json_encode(['foo' => 'bar']));

        return $httpClient;
    }
}
