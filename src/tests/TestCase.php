<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mockery;
use Mockery\MockInterface;
use OneUpReviews\Foundation\Exceptions\Handler;
use Exception;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    public function mockAndBind(string $class): MockInterface
    {
        $mock = $this->mock($class);
        $this->app->instance($class, $mock);

        return $mock;
    }

    public function mock(string $class): MockInterface
    {
        return Mockery::mock($class);
    }

    protected function disableExceptionHandling(): void
    {
        app()->instance(Handler::class, new class extends Handler {
            public function __construct() {}
            public function report(Exception $e){}
            public function render($request, Exception $e)
            {
                throw $e;
            }
        });
    }

    public function getJsonFromFile(string $filePath): string
    {
        return file_get_contents(base_path($filePath));
    }
}
