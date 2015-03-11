<?php

namespace CloudFS\Exception;


class BitcasaError extends \Exception {

    private $status;

    /**
     * Initializes the Bitcasa Error instance.
     *
     * @param BitcasaStatus $status The error status.
     */
    public function __construct($status) {
        $this->status = $status;
        parent::__construct($status->errorMessage());
    }

    /**
     * Retrieves the error status.
     *
     * @return The error status.
     */
    public function getStatus() {
        return $this->status;
    }

}