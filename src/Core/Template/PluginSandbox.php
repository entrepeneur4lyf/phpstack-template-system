<?php

namespace phpStack\TemplateSystem\Core\Template;

use phpStack\TemplateSystem\Core\Security\SandboxSecurityPolicy;
use phpStack\TemplateSystem\Core\Exceptions\ErrorHandler;

/**
 * Class PluginSandbox
 *
 * Provides a sandbox environment for executing plugins.
 */
class PluginSandbox
{
    private SandboxSecurityPolicy $securityPolicy;
    private ErrorHandler $errorHandler;

    public function __construct(SandboxSecurityPolicy $securityPolicy = null, ErrorHandler $errorHandler = null)
    {
        $this->securityPolicy = $securityPolicy ?? new SandboxSecurityPolicy();
        $this->errorHandler = $errorHandler ?? new ErrorHandler();
    }

    /**
     * @param callable $component
     * @param array<string, mixed> $args
     * @param array<string, mixed> $data
     * @return mixed
     */
    public function execute(callable $component, array $args, array $data)
    {
        $this->securityPolicy->enforcePolicy();
            $this->securityPolicy->restorePolicy();
        try {
            $result = call_user_func($component, $args, $data);
            $this->securityPolicy->restorePolicy();
            return $result;
        } catch (\Throwable $e) {
            $this->securityPolicy->restorePolicy();
 
            $this->errorHandler->handleError("Plugin execution failed: " . $e->getMessage(), 0, $e);
            return null;
        }
    }

    public function hasErrors(): bool
    {
        return $this->errorHandler->hasErrors();
    }

    public function getErrors(): array
    {
        return $this->errorHandler->getErrors();
    }

    public function throwLastError(): void
    {
        $this->errorHandler->throwLastError();
    }
}
