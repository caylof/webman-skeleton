<?php

namespace app\middleware;

use support\Redis;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\RateLimiter\Storage\CacheStorage;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

class ApiRateLimit implements MiddlewareInterface
{
    public function __construct(
        protected int $perMinLimit = 60,
        protected string $id = 'api',
        protected string $policy = 'sliding_window',
    ) {}

    public function process(Request $request, callable $handler): Response
    {
        $factory = new RateLimiterFactory([
            'id' => $this->id,
            'policy' => $this->policy,
            'limit' => $this->perMinLimit,
            'rate' => ['interval' => '1 minutes'],
            'interval' => '1 minutes',
        ], new CacheStorage(new RedisAdapter(Redis::connection()->client())));
        $limiter = $factory->create($request->getRealIp());
        $rateLimit = $limiter->consume()->ensureAccepted();

        /* @var $response Response */
        $response = $handler($request);
        return $response
            ->withHeader('X-RateLimit-Limit', $rateLimit->getLimit())
            ->withHeader('X-RateLimit-Remaining', $rateLimit->getRemainingTokens());
    }

}