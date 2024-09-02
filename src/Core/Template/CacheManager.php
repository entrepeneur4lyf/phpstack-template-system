<?php

namespace phpStack\Core\Template;

class CacheManager
{
    private $localCache;
    private $distributedCache;
    private $useDistributedCache;

    public function __construct(ComponentCache $localCache, DistributedCache $distributedCache, bool $useDistributedCache = false)
    {
        $this->localCache = $localCache;
        $this->distributedCache = $distributedCache;
        $this->useDistributedCache = $useDistributedCache;
    }

    public function get(string $key)
    {
        if ($this->useDistributedCache) {
            return $this->distributedCache->get($key);
        }
        return $this->localCache->get($key);
    }

    public function set(string $key, $value, int $ttl = 3600): void
    {
        if ($this->useDistributedCache) {
            $this->distributedCache->set($key, $value, $ttl);
        } else {
            $this->localCache->set($key, $value);
        }
    }

    public function has(string $key): bool
    {
        if ($this->useDistributedCache) {
            return $this->distributedCache->has($key);
        }
        return $this->localCache->has($key);
    }

    public function remove(string $key): void
    {
        if ($this->useDistributedCache) {
            $this->distributedCache->remove($key);
        } else {
            $this->localCache->remove($key);
        }
    }

    public function clear(): void
    {
        if ($this->useDistributedCache) {
            $this->distributedCache->clear();
        } else {
            $this->localCache->clear();
        }
    }

    public function setUseDistributedCache(bool $useDistributedCache): void
    {
        $this->useDistributedCache = $useDistributedCache;
    }

    public function generateCacheKey(string $componentName, array $args): string
    {
        return $this->localCache->generateCacheKey($componentName, $args);
    }
}