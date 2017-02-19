# Clarifai API Client

[![Latest Stable Version](https://poser.pugx.org/fabriceclementz/clarifai-php/v/stable)](https://packagist.org/packages/fabriceclementz/clarifai-php)
[![Total Downloads](https://poser.pugx.org/fabriceclementz/clarifai-php/downloads)](https://packagist.org/packages/fabriceclementz/clarifai-php)
[![License](https://poser.pugx.org/fabriceclementz/clarifai-php/license)](https://packagist.org/packages/fabriceclementz/clarifai-php)
[![Build Status](https://travis-ci.org/fabriceclementz/clarifai-php.svg?branch=master)](https://travis-ci.org/fabriceclementz/clarifai-php)
[![Build Status](https://travis-ci.org/fabriceclementz/clarifai-php.svg?branch=master)](https://travis-ci.org/fabriceclementz/clarifai-php)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/fabriceclementz/clarifai-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/fabriceclementz/clarifai-php/?branch=master)


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
