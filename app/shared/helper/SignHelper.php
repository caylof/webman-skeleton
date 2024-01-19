<?php

namespace app\shared\helper;

class SignHelper
{
    public function __construct(
        // 签名密钥
        protected string $secret,
        // 过期时长，单位秒，默认 300 秒
        protected int $dueTimeSec = 300
    ){}

    public function check(string $signStr, string|int|float ...$data): bool
    {
        $pieces = explode(':', $signStr);
        if (count($pieces) !== 2) {
            return false;
        }

        [$timestamp, $sign] = $pieces;
        $timestamp = (int)$timestamp;
        if (time() - $timestamp > $this->dueTimeSec) {
            return false;
        }

        return 0 === strcmp($timestamp.':'.$sign, $this->generateWithTimestamp($timestamp, ...$data));
    }

    protected function generateWithTimestamp(int $timestamp, string|int|float ...$data): string
    {
        $timestamp = (string)$timestamp;
        return $timestamp . ':'. hash('sha256', join('', $data) . $this->secret . $timestamp);
    }

    public function generate(string|int|float ...$data): string
    {
        return $this->generateWithTimestamp(time(), ...$data);
    }
}
