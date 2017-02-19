<?php

namespace Fab\Clarifai\Tests;

use Mockery;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

abstract class TestCase extends PHPUnitTestCase
{
    public function tearDown()
    {
        Mockery::close();

        parent::tearDown();
    }
}
