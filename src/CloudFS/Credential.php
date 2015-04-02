<?php
/**
 * Created by PhpStorm.
 * User: dhanushka
 * Date: 3/10/15
 * Time: 12:53 PM
 */

namespace CloudFS;


/**
 * Defines the credential properties.
 */
class Credential {

    private $endpoint;
    private $applicationContext;
    private $accessToken;
    private $tokenType;
    private $session;

    /**
     * Initializes the Credentials instance.
     *
     * @param Session $session Session variable.
     * @param string $endpoint The bitcasa endpoint.
     */
    public function __construct($session = null, $endpoint = NULL) {
        $this->applicationContext = null;
        $this->endpoint = $endpoint;
        $this->session = $session;
    }

    /**
     * Retrieves the credentials api endpoint.
     *
     * @return The api endpoint.
     */
    public function getEndPoint() {
        return $this->endpoint;
    }

    /**
     * Retrieves the application context.
     *
     * @return The application context.
     */
    public function getApplicationContext() {
        return $this->applicationContext;
    }

    /**
     * Retrieves the credentials access token.
     *
     * @return The access token.
     */
    public function getAccessToken() {
        return $this->accessToken;
    }

    /**
     * Sets the credentials access token.
     *
     * @param string $token The access token to be set.
     */
    public function setAccessToken($token) {
        $this->accessToken = $token;
    }

    /**
     * Retrieves the credential token type.
     *
     * @return The token type.
     */
    public function getTokenType() {
        return $this->tokenType;
    }

    /**
     * Sets the credential token type.
     *
     * @param string $type The token type to be set.
     */
    public function setTokenType($type) {
        $this->tokenType = $type;
    }

    /**
     * Retrieves the request url for credentials.
     *
     * @param string $method Request url method variable.
     * @param string $operation Request url operation.
     * @param mixed $params Parameters for request url.
     * @return string The request url.
     */
    public function getRequestUrl($method, $operation = null, $params = null) {
        return BitcasaUtils::getRequestUrl($this, $method, $operation, $params);
    }

    /**
     * Retrieves the credential session.
     *
     * @return The session.
     */
    public function getSession() {
        return $this->session;
    }
}
