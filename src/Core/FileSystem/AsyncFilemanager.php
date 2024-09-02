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

    public function readFile(string $filename): Fiber|null
    {
        return new Fiber(function () use ($filename) {
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

            if ($contents === false) {
                throw new \RuntimeException("Failed to read file: $filename");
            }
            $this->fileCacheManager->set($cacheKey, $contents);
            return $contents;
        });
    }

    public function writeFile(string $filename, string $content): Fiber|null
    {
        return new Fiber(function () use ($filename, $content) {
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
