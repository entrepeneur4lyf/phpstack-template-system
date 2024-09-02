<?php

namespace phpStack\Core\Template;

use Redis;

/**
 * Class DistributedCache
 *
 * Manages distributed caching for templates.
 */
class DistributedCache
{
    /**
     * @var Redis The Redis client instance for managing cache.
     */
    private Redis $redis;

    /**
     * DistributedCache constructor.
     *
     * DistributedCache constructor.
     *
     * @param string $host The Redis host address.
     * @param int $port The Redis port number.
     */
    public function __construct(string $host = 'localhost', int $port = 6379)
    {
        $this->redis = new Redis();
        $this->redis->connect($host, $port);
    }

    /**
     * Retrieves a value from the cache.
     *
     * @param string $key The cache key.
     * Retrieves a value from the cache.
     *
     * @param string $key The cache key.
     * @return mixed|null The cached value or null if the key does not exist.
     */
    public function get(string $key)
    {
        $value = $this->redis->get($key);
        return $value !== false ? unserialize($value) : null;
    }

    /**
     * Stores a value in the cache.
     *
     * @param string $key The cache key.
     * @param mixed $value The value to cache.
     * @param int $ttl Time-to-live in seconds for the cached item.
     */
    public function set(string $key, $value, int $ttl = 3600): void
    {
        $this->redis->setex($key, $ttl, serialize($value));
    }

    /**
     * Checks if a cache key exists.
     *
     * @param string $key The cache key.
     * Checks if a cache key exists.
     *
     * @param string $key The cache key.
     * @return bool True if the key exists in the cache, false otherwise.
     */
    public function has(string $key): bool
    {
        return $this->redis->exists($key);
    }

    /**
     * Clears all entries from the cache.
     */
    public function clear(): void
    {
        $this->redis->flushAll();
    }
}
