<?php

namespace CloudFS\Exception;

use CloudFS\Exception\BitcasaError;

/**
 * Class BitcasaStatus
 * Handles bitcasa status responses.
 * @package CloudFS\Exception
 */
class BitcasaStatus {
    private $status;
    private $message;
    private $code;
    private $response;

    /**
     * Initializes the Bitcasa status instance.
     *
     * @param object $response
     */
    public function __construct($response) {
        $this->response = $response;
//        $this->status = isset($response["result"]) && $response["result"] != null && $response["result"] != false;
        $this->status = !isset($response["error"]);
        $this->code = 0;
        $message = isset($response["error"]) && isset($response["error"]["message"])
            ? $response["result"]["message"] : "";
        $this->code = isset($response["error"]) && isset($response["error"]["code"])
            ? $response["result"]["code"] : 0;
        $this->message = $message;
    }

    /**
     * Retrieves the status error code.
     *
     * @return The error code.
     */
    public function errorCode() {
        return $this->code;
    }

    /**
     * Retrieves the status error message.
     *
     * @return The error message.
     */
    public function errorMessage() {
        return $this->message;
    }

    /**
     * Retrieves the status success status.
     *
     * @return The success status.
     */
    public function success()
    {
        return $this->status;
    }

    /**
     * Handles errors according to success status.
     *
     * @throws BitcasaError
     */
    public function throwOnFailure() {
        if (!$this->success()) {
            if (getenv("BC_DEBUG") != null) {
                var_dump($this->response);
                print "BitcasaError: " . $this->code . " => " . $this->message . "\n";
            }

            throw new BitcasaError($this);
        }
    }
}