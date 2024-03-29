<?php

namespace app\exception;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\RateLimiter\Exception\RateLimitExceededException;
use Throwable;
use Illuminate\Validation\ValidationException;
use Webman\Exception\ExceptionHandler;
use Webman\Http\Request;
use Webman\Http\Response;

class Handler extends ExceptionHandler
{
    public $dontReport = [
        AuthenticationException::class,
        BusinessException::class,
        ValidationException::class,
        RateLimitExceededException::class,
        ModelNotFoundException::class,
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
            $exception instanceof BusinessException => $this->renderJsonResponse($exception->status ?? 423, [
                'message' => $exception->getMessage(),
            ]),
            $exception instanceof AuthenticationException => $this->renderJsonResponse($exception->status ?? 401, [
                'message' => $exception->getMessage(),
            ]),
            $exception instanceof ModelNotFoundException => $this->renderJsonResponse(404, [
                'message' => $exception->getMessage(),
            ]),
            $exception instanceof RateLimitExceededException => $this->renderJsonResponse(429, [
                'message' => 'Too many requests.',
            ])->withHeader('X-RateLimit-Limit', $exception->getLimit())
                ->withHeader('X-RateLimit-Remaining', $exception->getRemainingTokens())
                ->withHeader('X-RateLimit-Reset', $exception->getRetryAfter()->diff(Carbon::now())->s),
            default => parent::render($request, $exception),
        };
    }

    private function renderJsonResponse(int $statusCode, array $data, int $options = JSON_UNESCAPED_UNICODE): Response
    {
        return new Response($statusCode, ['Content-Type' => 'application/json'], json_encode($data, $options));
    }
}
