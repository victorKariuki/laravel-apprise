<?php

namespace BrevaimLabs\LaravelApprise\Exceptions;

use Exception;

/**
 * Class NotificationFailedException
 * 
 * Custom exception for handling notification failures.
 */
class NotificationFailedException extends Exception
{
    /**
     * NotificationFailedException constructor.
     *
     * @param string $message The exception message
     * @param int $code The exception code (optional)
     * @param Exception|null $previous The previous exception (optional)
     */
    public function __construct(string $message = "Notification failed", int $code = 0, Exception $previous = null)
    {
        // Call the parent constructor to set the message, code, and previous exception
        parent::__construct($message, $code, $previous);
    }

    /**
     * String representation of the exception.
     *
     * @return string
     */
    public function __toString(): string
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
