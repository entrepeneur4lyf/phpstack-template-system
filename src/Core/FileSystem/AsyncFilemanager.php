<?php

namespace phpStack\TemplateSystem\Core\FileSystem;

use Fiber;
use phpStack\Core\Cache\FileCacheManager;

class AsyncFileManager
{
    private FileCacheManager $fileCacheManager;

    public function __construct(string $cacheDir = '/tmp/async_file_cache', int $defaultTtl = 3600)
    {
        $this->fileCacheManager = new FileCacheManager($cacheDir, $defaultTtl);
    }

    /**
     * @return Fiber<mixed, mixed, string, mixed>
     */
    public function readFile(string $filename): Fiber
    {
        return new Fiber(function () use ($filename): string {
            $cacheKey = 'file_' . $filename;
            $cachedContent = $this->fileCacheManager->get($cacheKey);
            if ($cachedContent !== null) {
                return $cachedContent;
            }

            $handle = fopen($filename, 'rb');
            if ($handle === false) {
                throw new \RuntimeException("Failed to open file: $filename");
            }

            $contents = '';
            while (!feof($handle)) {
                $contents .= fread($handle, 8192);
            }
            fclose($handle);

            if ($contents === '') {
                throw new \RuntimeException("Failed to read file: $filename");
            }
            $this->fileCacheManager->set($cacheKey, $contents);
            return $contents;
        });
    }

    /**
     * @return Fiber<mixed, mixed, int, mixed>
     */
    public function writeFile(string $filename, string $content): Fiber
    {
        return new Fiber(function () use ($filename, $content): int {
            $handle = fopen($filename, 'wb');
            if ($handle === false) {
                throw new \RuntimeException("Failed to open file for writing: $filename");
            }

            $bytesWritten = fwrite($handle, $content);
            fclose($handle);

            if ($bytesWritten === false) {
                throw new \RuntimeException("Failed to write to file: $filename");
            }

            $cacheKey = 'file_' . $filename;
            $this->fileCacheManager->set($cacheKey, $content);
            return $bytesWritten;
        });
    }

    public function deleteFile(string $filename): void
    {
        if (!unlink($filename)) {
            throw new \RuntimeException("Failed to delete file: $filename");
        }
        $cacheKey = 'file_' . $filename;
        $this->fileCacheManager->delete($cacheKey);
    }
}
