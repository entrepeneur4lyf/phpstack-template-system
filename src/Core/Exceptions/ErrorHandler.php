<?php

namespace phpStack\TemplateSystem\Core\Exceptions;

/**
 * ErrorHandler class for managing and handling errors in the template system.
 */
class ErrorHandler
{
    /** @var array Array to store encountered errors. */
    private $errors = [];

    /**
     * Handle an error by storing it in the errors array.
     *
     * @param string $message The error message.
     * @param int $code The error code (default: 0).
     * @param \Throwable|null $previous The previous throwable used for exception chaining (default: null).
     */
    public function handleError(string $message, int $code = 0, \Throwable $previous = null): void
    {
        $this->errors[] = [
            'message' => $message,
            'code' => $code,
            'previous' => $previous
        ];
    }

    /**
     * Check if there are any errors.
     *
     * @return bool True if there are errors, false otherwise.
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Get all stored errors.
     *
     * @return array An array of all stored errors.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Clear all stored errors.
     */
    public function clearErrors(): void
    {
        $this->errors = [];
    }

    /**
     * Throw the last error as a RuntimeException.
     *
     * @throws \RuntimeException If there are any errors stored.
     */
    public function throwLastError(): void
    {
        if ($this->hasErrors()) {
            $lastError = end($this->errors);
            throw new \RuntimeException($lastError['message'], $lastError['code'], $lastError['previous']);
        }
    }
}
