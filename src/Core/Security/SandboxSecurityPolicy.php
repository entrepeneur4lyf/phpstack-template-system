<?php

namespace PHPStack\TemplateSystem\Core\Security;

/**
 * SandboxSecurityPolicy class for enforcing security policies in a sandbox environment.
 *
 * This class provides methods to restrict file system access, disable dangerous functions,
 * set memory limits, and control execution time for improved security in sandbox environments.
 */
class SandboxSecurityPolicy
{
    /** @var array<string, string|false> Original INI settings to be restored later */
    private array $originalIniSettings = [];
    
    /** @var array<string> List of functions to be disabled in the sandbox */
    private array $disabledFunctions = [
        'exec', 'passthru', 'shell_exec', 'system', 'proc_open', 'popen', 'curl_exec', 
        'curl_multi_exec', 'parse_ini_file', 'show_source', 'file_put_contents', 'file_get_contents'
    ];

    /**
     * Enforce the security policy by applying all restrictions.
     */
    public function enforcePolicy(): void
    {
        $this->restrictFileSystem();
        $this->disableDangerousFunctions();
        $this->setMemoryLimit();
        $this->setExecutionTimeLimit();
    }

    /**
     * Restore the original INI settings, effectively removing the enforced policy.
     */
    public function restorePolicy(): void
    {
        foreach ($this->originalIniSettings as $key => $value) {
            ini_set($key, $value);
        }
    }

    /**
     * Restrict file system access to the temporary directory.
     */
    private function restrictFileSystem(): void
    {
        $this->setIniSetting('open_basedir', sys_get_temp_dir());
    }

    /**
     * Disable dangerous functions by adding them to the disable_functions INI setting.
     */
    private function disableDangerousFunctions(): void
    {
        $currentDisabledFunctions = explode(',', (string)ini_get('disable_functions'));
        $newDisabledFunctions = array_unique(array_merge($currentDisabledFunctions, $this->disabledFunctions));
        $this->setIniSetting('disable_functions', implode(',', $newDisabledFunctions));
    }

    /**
     * Set the memory limit for the sandbox environment.
     */
    private function setMemoryLimit(): void
    {
        $this->setIniSetting('memory_limit', '128M');
    }

    /**
     * Set the maximum execution time for scripts in the sandbox environment.
     */
    private function setExecutionTimeLimit(): void
    {
        $this->setIniSetting('max_execution_time', '30');
    }

    /**
     * Set an INI setting and store the original value for later restoration.
     *
     * @param string $key The INI setting key.
     * @param string $value The new value for the INI setting.
     */
    private function setIniSetting(string $key, string $value): void
    {
        $this->originalIniSettings[$key] = ini_get($key);
        ini_set($key, $value);
    }
}