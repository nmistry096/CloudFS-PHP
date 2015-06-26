<?php

namespace CloudFS\Exception;

/**
 * Class BitcasaError
 * Handles the bitcasa error responses.
 * @package CloudFS\Exception
 */
class BitcasaError extends \Exception {

    private $httpCode;

    /**
     * Initializes the Bitcasa Error instance.
     *
     * @param array $jsonResponse The JSON of the error.
     * @param int $httpCode Status code of the request that triggered the error.
     */
    public function __construct($jsonResponse, $httpCode) {
        if (!isset($jsonResponse["error"])) {
            throw Exception("Attempted to raise an exception from a non-error response: \r\n" . json_encode($json_response));
        }
        $this->httpCode = $httpCode;
        parent::__construct($jsonResponse["error"]["message"], $jsonResponse["error"]["code"]);
    }

    /**
     * Retrieves the error status.
     *
     * @return The error status.
     */
    public function getHTTPStatus() {
        return $this->httpCode;
    }

}