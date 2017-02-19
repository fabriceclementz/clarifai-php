# Clarifai API Client

A PHP client for the [Clarifai API](https://developer.clarifai.com).

Work in progress.

## Installation

### Via composer

```
composer require fabriceclementz/clarifai-php
```

## Usage

### Fetch an access token

```
use GuzzleHttp\Client as HttpClient;
use Fab\Clarifai\Client;

// Instantiate a new client.
$client = new Client(new HttpClient(), 'CLIENT_ID', 'CLIENT_SECRET');

// Fetch an access token.
$response = $client->accessToken();
```

### Predict the content of an image

```
$response = $client
    ->withAccessToken($response['access_token'])
    ->predict(['https://samples.clarifai.com/metro-north.jpg']);
```

## Testing

```
composer test
```
