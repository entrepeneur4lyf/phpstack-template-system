<?php

namespace phpStack\Core\Template;

/**
 * Class CacheManager
 *
 * Manages caching for templates to improve performance.
 */
class CacheManager
{
    private $localCache;
    private $distributedCache;
    private $useDistributedCache;

    /**
     * CacheManager constructor.
     *
     * @param ComponentCache $localCache The local cache instance.
     * @param DistributedCache $distributedCache The distributed cache instance.
     * @param bool $useDistributedCache Whether to use distributed cache.
     */
    public function __construct(ComponentCache $localCache, DistributedCache $distributedCache, bool $useDistributedCache = false)
    {
        $this->localCache = $localCache;
        $this->distributedCache = $distributedCache;
        $this->useDistributedCache = $useDistributedCache;
    }

    /**
     * Retrieves a value from the cache.
     *
     * @param string $key The cache key.
     * @return mixed|null The cached value or null if not found.
     */
    public function get(string $key)
    {
        if ($this->useDistributedCache) {
            return $this->distributedCache->get($key);
        }
        return $this->localCache->get($key);
    }

    /**
     * Stores a value in the cache.
     *
     * @param string $key The cache key.
     * @param mixed $value The value to cache.
     * @param int $ttl Time-to-live in seconds.
     */
    public function set(string $key, $value, int $ttl = 3600): void
    {
        if ($this->useDistributedCache) {
            $this->distributedCache->set($key, $value, $ttl);
        } else {
            $this->localCache->set($key, $value);
        }
    }

    /**
     * Checks if a cache key exists.
     *
     * @param string $key The cache key.
     * @return bool True if the key exists, false otherwise.
     */
    public function has(string $key): bool
    {
        if ($this->useDistributedCache) {
            return $this->distributedCache->has($key);
        }
        return $this->localCache->has($key);
    }

    /**
     * Removes a cache entry.
     *
     * @param string $key The cache key.
     */
    public function remove(string $key): void
    {
        if ($this->useDistributedCache) {
            $this->distributedCache->remove($key);
        } else {
            $this->localCache->remove($key);
        }
    }

    /**
     * Clears all cache entries.
     */
    public function clear(): void
    {
        if ($this->useDistributedCache) {
            $this->distributedCache->clear();
        } else {
            $this->localCache->clear();
        }
    }

    /**
     * Sets whether to use distributed cache.
     *
     * @param bool $useDistributedCache True to use distributed cache, false otherwise.
     */
    public function setUseDistributedCache(bool $useDistributedCache): void
    {
        $this->useDistributedCache = $useDistributedCache;
    }

    /**
     * Generates a cache key for a component.
     *
     * @param string $componentName The component name.
     * @param array $args The component arguments.
     * @return string The generated cache key.
     */
    public function generateCacheKey(string $componentName, array $args): string
    {
        return $this->localCache->generateCacheKey($componentName, $args);
    }
}
