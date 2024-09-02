<?php

namespace phpStack\Core\Template;

use Redis;

class DistributedCache
{
    private $redis;

    public function __construct(string $host = 'localhost', int $port = 6379)
    {
        $this->redis = new Redis();
        $this->redis->connect($host, $port);
    }

    public function get(string $key)
    {
        $value = $this->redis->get($key);
        return $value !== false ? unserialize($value) : null;
    }

    public function set(string $key, $value, int $ttl = 3600): void
    {
        $this->redis->setex($key, $ttl, serialize($value));
    }

    public function has(string $key): bool
    {
        return $this->redis->exists($key);
    }

    public function clear(): void
    {
        $this->redis->flushAll();
    }
}