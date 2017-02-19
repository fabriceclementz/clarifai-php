<?php

namespace Fab\Clarifai;

class Input
{
    /**
     * The image URL.
     * @var string
     */
    protected $url;

    /**
     * Instantiate a new input from an url.
     *
     * @param  string $url The image URL.
     * @return Input
     */
    public static function fromUrl($url)
    {
        $input = new static();
        $input->setUrl($url);

        return $input;
    }

    /**
     * Get the image URL.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Format the input for querying the Clarifai API.
     *
     * @return array
     */
    public function format()
    {
        return [
            'data' => [
                'image' => [
                    'url' => $this->url,
                ]
            ]
        ];
    }
}
