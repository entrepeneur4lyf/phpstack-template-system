<?php

namespace phpStack\Core\Cache;

/**
 * FileCacheManager class for managing file-based caching with OPcache support.
 */
class FileCacheManager
{
    /** @var string The directory where cache files are stored. */
    private string $cacheDir;

    /** @var int The default Time To Live (TTL) for cache items. */
    private int $defaultTtl;

    /**
     * Constructor for FileCacheManager.
     *
     * @param string $cacheDir  The directory to store cache files (default: '/tmp/file_cache').
     * @param int    $defaultTtl The default Time To Live for cache items in seconds (default: 3600).
     */
    public function __construct(string $cacheDir = '/tmp/file_cache', int $defaultTtl = 3600)
    {
        $this->cacheDir = $cacheDir;
        $this->defaultTtl = $defaultTtl;
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }

    /**
     * Retrieve a value from the cache.
     *
     * @param string $key The key of the cache item to retrieve.
     * @return mixed|null The cached value if found and not expired, null otherwise.
     */
    public function get(string $key)
    {
        $filename = $this->getCacheFilename($key);
        if (!file_exists($filename)) {
            return null;
        }

        $data = $this->loadFromOPcache($filename);
        if ($data === false || $data['expiry'] < time()) {
            $this->delete($key);
            return null;
        }

        return $data['value'];
    }

    /**
     * Store a value in the cache.
     *
     * @param string $key   The key under which to store the value.
     * @param mixed  $value The value to store.
     * @param int|null $ttl The Time To Live in seconds (null uses the default TTL).
     */
    public function set(string $key, $value, int $ttl = null): void
    {
        $ttl = $ttl ?? $this->defaultTtl;
        $data = [
            'value' => $value,
            'expiry' => time() + $ttl
        ];
        $filename = $this->getCacheFilename($key);
        $this->saveToOPcache($filename, $data);
    }

    /**
     * Delete a value from the cache.
     *
     * @param string $key The key of the cache item to delete.
     */
    public function delete(string $key): void
    {
        $filename = $this->getCacheFilename($key);
        if (file_exists($filename)) {
            unlink($filename);
            if (function_exists('opcache_invalidate')) {
                opcache_invalidate($filename, true);
            }
        }
    }

    /**
     * Clear all items from the cache.
     */
    public function clear(): void
    {
        $files = glob($this->cacheDir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
                if (function_exists('opcache_invalidate')) {
                    opcache_invalidate($file, true);
                }
            }
        }
    }

    /**
     * Get the filename for a cache key.
     *
     * @param string $key The cache key.
     * @return string The full path to the cache file.
     */
    private function getCacheFilename(string $key): string
    {
        return $this->cacheDir . '/' . md5($key) . '.php';
    }

    /**
     * Load data from a file, using OPcache if available.
     *
     * @param string $filename The filename to load.
     * @return mixed The data stored in the file.
     */
    private function loadFromOPcache(string $filename)
    {
        if (function_exists('opcache_is_script_cached') && !opcache_is_script_cached($filename)) {
            if (function_exists('opcache_compile_file')) {
                opcache_compile_file($filename);
            }
        }
        return include $filename;
    }

    /**
     * Save data to a file and update OPcache if available.
     *
     * @param string $filename The filename to save to.
     * @param array  $data     The data to save.
     */
    private function saveToOPcache(string $filename, array $data): void
    {
        $content = '<?php return ' . var_export($data, true) . ';';
        file_put_contents($filename, $content);
        if (function_exists('opcache_invalidate')) {
            opcache_invalidate($filename, true);
        }
        if (function_exists('opcache_compile_file')) {
            opcache_compile_file($filename);
        }
    }
}
