<?php

declare(strict_types=1);

namespace phpStack\Core\Template;

/**
 * Class DebugManager
 *
 * Provides debugging tools for template rendering.
 */
class DebugManager
{
    private $componentHierarchy = [];
    private $renderTimes = [];
    private $isDebugMode = false;

    public function setDebugMode(bool $isDebugMode): void
    {
        $this->isDebugMode = $isDebugMode;
    }

    public function startComponentRender(string $componentName, int $depth): void
    {
        if (!$this->isDebugMode) return;

        $this->componentHierarchy[] = [
            'name' => $componentName,
            'depth' => $depth,
            'start_time' => microtime(true)
        ];
    }

    public function endComponentRender(string $componentName): void
    {
        if (!$this->isDebugMode) return;

        $lastIndex = count($this->componentHierarchy) - 1;
        if ($lastIndex >= 0 && $this->componentHierarchy[$lastIndex]['name'] === $componentName) {
            $this->componentHierarchy[$lastIndex]['end_time'] = microtime(true);
            $renderTime = $this->componentHierarchy[$lastIndex]['end_time'] - $this->componentHierarchy[$lastIndex]['start_time'];
            $this->renderTimes[$componentName] = ($this->renderTimes[$componentName] ?? 0) + $renderTime;
        }
    }

    public function getComponentHierarchy(): array
    {
        return $this->componentHierarchy;
    }

    public function getRenderTimes(): array
    {
        return $this->renderTimes;
    }

    public function generateDebugOutput(): string
    {
        if (!$this->isDebugMode) return '';

        $output = "<div class='debug-info'>";
        $output .= "<h2>Component Hierarchy</h2>";
        $output .= $this->renderComponentHierarchy();
        $output .= "<h2>Render Times</h2>";
        $output .= $this->renderRenderTimes();
        $output .= "</div>";

        return $output;
    }

    private function renderComponentHierarchy(): string
    {
        $output = "<ul>";
        $stack = [];
        foreach ($this->componentHierarchy as $component) {
            while (!empty($stack) && $stack[count($stack) - 1]['depth'] >= $component['depth']) {
                array_pop($stack);
                $output .= "</li></ul>";
            }
            $output .= "<li>{$component['name']}";
            if (isset($component['end_time'])) {
                $renderTime = ($component['end_time'] - $component['start_time']) * 1000;
                $output .= sprintf(" (%.2fms)", $renderTime);
            }
            $output .= "<ul>";
            $stack[] = $component;
        }
        while (!empty($stack)) {
            array_pop($stack);
            $output .= "</li></ul>";
        }
        $output .= "</ul>";
        return $output;
    }

    private function renderRenderTimes(): string
    {
        arsort($this->renderTimes);
        $output = "<table><tr><th>Component</th><th>Total Render Time</th></tr>";
        foreach ($this->renderTimes as $component => $time) {
            $timeMs = $time * 1000;
            $output .= sprintf("<tr><td>%s</td><td>%.2fms</td></tr>", $component, $timeMs);
        }
        $output .= "</table>";
        return $output;
    }
}
