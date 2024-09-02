<?php

namespace phpStack\Core\Template;

/**
 * Class ComponentCache
 *
 * Caches components to optimize rendering.
 */
class ComponentCache
{
    private $cache = [];
    private $ttl;

    public function __construct(int $ttl = 3600)
    {
        $this->ttl = $ttl;
    }

    public function get(string $key)
    {
        if (isset($this->cache[$key]) && $this->cache[$key]['expires'] > time()) {
            return $this->cache[$key]['value'];
        }
        return null;
    }

    public function set(string $key, $value): void
    {
        $this->cache[$key] = [
            'value' => $value,
            'expires' => time() + $this->ttl
        ];
    }

    public function generateCacheKey(string $componentName, array $args): string
    {
        return $componentName . '_' . md5(serialize($args));
    }
}
