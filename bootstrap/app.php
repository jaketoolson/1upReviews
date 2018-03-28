<?php

$app = new OneUpReviews\Foundation\Application(realpath(__DIR__.'/../'));

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    OneUpReviews\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    OneUpReviews\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    OneUpReviews\Exceptions\Handler::class
);

return $app;
