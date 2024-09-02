<?php

declare(strict_types=1);

namespace phpStack\Core\Template;

use phpStack\Core\Cache\CacheInterface;

/**
 * Class ComponentCache
 *
 * Manages caching for individual components.
 */
class ComponentCache
{
    private CacheInterface $cache;
    private int $ttl;

    /**
     * ComponentCache constructor.
     *
     * @param CacheInterface $cache The cache instance.
     * @param int $ttl Time-to-live in seconds.
     */
    public function __construct(CacheInterface $cache, int $ttl = 3600)
    {
        $this->cache = $cache;
        $this->ttl = $ttl;
    }

    /**
     * Retrieves a cached value.
     *
     * @param string $key The cache key.
     * @return mixed|null The cached value or null if not found.
     */
    public function get(string $key): mixed
    {
        return $this->cache->get($key);
    }

    /**
     * Stores a value in the cache.
     *
     * @param string $key The cache key.
     * @param mixed $value The value to cache.
     */
    public function set(string $key, mixed $value): void
    {
        $this->cache->set($key, $value, $this->ttl);
    }
}
