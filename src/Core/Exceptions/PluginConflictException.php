<?php

namespace phpStack\TemplateSystem\Core\Exceptions;

/**
 * Exception thrown when there is a conflict between plugins.
 */
class PluginConflictException extends \RuntimeException
{
    /**
     * PluginConflictException constructor.
     *
     * @param string $message The exception message.
     * @param int $code The exception code.
     * @param \Throwable|null $previous The previous throwable used for exception chaining.
     */
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}