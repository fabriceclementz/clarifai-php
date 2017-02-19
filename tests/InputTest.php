<?php

namespace Fab\Clarifai\Tests;

use Fab\Clarifai\Input;

class InputTest extends TestCase
{
    /** @test */
    function can_instantiate_an_input()
    {
        $input = new Input();

        $this->assertInstanceOf(Input::class, $input);
    }

    /** @test */
    function can_create_input_from_url()
    {
        $input = Input::fromUrl('valid-url');

        $this->assertInstanceOf(Input::class, $input);
        $this->assertEquals('valid-url', $input->getUrl());
    }

    /** @test */
    function can_format_input_for_querying_api()
    {
        $format = [
            'data' => [
                'image' => [
                    'url' => 'valid-url',
                ]
            ]
        ];

        $input = Input::fromUrl('valid-url');

        $this->assertEquals($format, $input->format());
        $this->assertTrue(is_array($input->format()));
    }
}
