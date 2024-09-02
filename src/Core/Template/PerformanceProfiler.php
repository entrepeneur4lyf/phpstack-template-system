<?php

namespace phpStack\TemplateSystem\Core\Template;

/**
 * Class PerformanceProfiler
 *
 * Profiles the performance of template rendering.
 */
class PerformanceProfiler
{
    /** @var array<string, float> */
    private array $profiles = [];

    /** @var array<string, float> */
    private array $startTimes = [];

    public function startProfile(string $name): void
    {
        $this->startTimes[$name] = microtime(true);
    }

    public function endProfile(string $name): void
    {
        if (!isset($this->startTimes[$name])) {
            throw new \RuntimeException("Profile '{$name}' was not started.");
        }

        $duration = microtime(true) - $this->startTimes[$name];
        $this->profiles[$name] = $duration;
        unset($this->startTimes[$name]);
    }

    public function getProfile(string $name): ?float
    {
        return $this->profiles[$name] ?? null;
    }

    /**
     * @return array<string, float>
     */
    public function getAllProfiles(): array
    {
        return $this->profiles;
    }

    public function reset(): void
    {
        $this->profiles = [];
        $this->startTimes = [];
    }
}
