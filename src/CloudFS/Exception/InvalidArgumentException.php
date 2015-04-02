<?php

namespace CloudFS\Exception;

/**
 * Class InvalidArgumentException
 * Handles bitcasa invalid argument exception.
 * @package CloudFS\Exception
 */
class InvalidArgumentException extends \Exception {

    /**
     * Creates an instance of Invalid Argument Exception.
     *
     * @param string $message The error message.
     */
    public function __construct($message) {
        parent::__construct($message);
    }

}