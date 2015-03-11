<?php

namespace CloudFS\Exception;


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