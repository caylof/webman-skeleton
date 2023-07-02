<?php

namespace app\exception;

use Throwable;
use Illuminate\Validation\ValidationException;
use Webman\Exception\ExceptionHandler;
use Webman\Http\Request;
use Webman\Http\Response;

class Handler extends ExceptionHandler
{
    public $dontReport = [
        AuthenticationException::class,
        ValidationException::class,
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render(Request $request, Throwable $exception): Response
    {
        return match (true) {
            $exception instanceof ValidationException => $this->renderJsonResponse($exception->status ?? 422, [
                'message' => $exception->getMessage(),
                'errors' => $exception->errors(),
            ]),
            $exception instanceof AuthenticationException => $this->renderJsonResponse($exception->status ?? 401, [
                'message' => $exception->getMessage(),
            ]),
            default => parent::render($request, $exception),
        };
    }

    private function renderJsonResponse(int $statusCode, array $data, int $options = JSON_UNESCAPED_UNICODE): Response
    {
        return new Response($statusCode, ['Content-Type' => 'application/json'], json_encode($data, $options));
    }
}
