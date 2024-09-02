<?php

namespace phpStack\TemplateSystem\Core\FileSystem;

use Fiber;
use phpStack\Core\Cache\FileCacheManager;

/**
 * AsyncFileManager class for asynchronous file operations with caching support.
 */
class AsyncFileManager
{
    /** @var FileCacheManager The file cache manager instance. */
    private FileCacheManager $fileCacheManager;

    /**
     * AsyncFileManager constructor.
     *
     * @param string $cacheDir The directory to store cache files (default: '/tmp/async_file_cache').
     * @param int $defaultTtl The default Time To Live for cache items in seconds (default: 3600).
     */
    public function __construct(string $cacheDir = '/tmp/async_file_cache', int $defaultTtl = 3600)
    {
        $this->fileCacheManager = new FileCacheManager($cacheDir, $defaultTtl);
    }

    /**
     * Asynchronously read a file, using cache if available.
     *
     * @param string $filename The name of the file to read.
     * @return Fiber A Fiber instance that will yield the file contents.
     * @throws \RuntimeException If the file cannot be read.
     */
    public function readFile(string $filename): Fiber
    {
        return new Fiber(function () use ($filename) {
            $cacheKey = 'file_' . $filename;
            $cachedContent = $this->fileCacheManager->get($cacheKey);
            if ($cachedContent !== null) {
                return $cachedContent;
            }

            $contents = @file_get_contents($filename);
            if ($contents === false) {
                throw new \RuntimeException("Failed to read file: $filename");
            }
            $this->fileCacheManager->set($cacheKey, $contents);
            return $contents;
        });
    }

    /**
     * Asynchronously write content to a file.
     *
     * @param string $filename The name of the file to write.
     * @param string $content The content to write to the file.
     * @return PromiseInterface A promise that resolves with the number of bytes written or rejects with an exception.
     */
    public function writeFile(string $filename, string $content): PromiseInterface
    {
        $deferred = new Deferred();

        Loop::get()->addTimer(0, function () use ($filename, $content, $deferred) {
            $result = @file_put_contents($filename, $content);
            if ($result === false) {
                $deferred->reject(new \RuntimeException("Failed to write file: $filename"));
            } else {
                $cacheKey = 'file_' . $filename;
                $this->fileCacheManager->set($cacheKey, $content);
                $deferred->resolve($result);
            }
        });

        return $deferred->promise();
    }

    /**
     * Asynchronously delete a file.
     *
     * @param string $filename The name of the file to delete.
     * @return PromiseInterface A promise that resolves with true if the file was deleted, or rejects with an exception.
     */
    public function deleteFile(string $filename): PromiseInterface
    {
        $deferred = new Deferred();

        Loop::get()->addTimer(0, function () use ($filename, $deferred) {
            $result = @unlink($filename);
            if ($result === false) {
                $deferred->reject(new \RuntimeException("Failed to delete file: $filename"));
            } else {
                $cacheKey = 'file_' . $filename;
                $this->fileCacheManager->delete($cacheKey);
                $deferred->resolve(true);
            }
        });

        return $deferred->promise();
    }
}
