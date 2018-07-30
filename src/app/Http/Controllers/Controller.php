<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var ResponseFactory
     */
    protected $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function json(array $data = [], int $status = 200, array $headers = [], int $options = 0): JsonResponse
    {
        return $this->responseFactory->json($data, $status, $headers, $options);
    }

    public function view(string $view, array $data = [], int $status = 200, array $headers = []): Response
    {
        return $this->responseFactory->view($view, $data, $status, $headers);
    }

    public function redirect(string $path, int $status = 302, array $headers = [], bool $secure = null): RedirectResponse
    {
        return $this->responseFactory->redirectTo($path, $status , $headers, $secure);
    }
}
