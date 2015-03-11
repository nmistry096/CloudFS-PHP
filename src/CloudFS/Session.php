<?php

/**
 * Bitcasa Client PHP SDK
 * Copyright (C) 2014 Bitcasa, Inc.
 *
 * This file contains an SDK in PHP for accessing the Bitcasa infinite drive.
 *
 * For support, please send email to support@bitcasa.com.
 */

namespace CloudFS;

use CloudFS\Filesystem;
use CloudFS\HTTPConnect;
use CloudFS\BitcasaUtils;
use CloudFS\Utils\BitcasaConstants;
use CloudFS\Credential;


/**
 * Defines a bitcasa session.
 */
class Session {

    private $clientId;
    private $clientSecret;
    private $credential;
    private $bitcasaClientApi;
    private $debug;
    private $adminClientId;
    private $adminClientSecret;

    /**
     * Initializes the Session instance.
     *
     * @param string $endpoint The bitcasa api endoint.
     * @param string $clientId The app client id.
     * @param string $clientSecret The app client secret.
     */
    public function __construct($endpoint, $clientId, $clientSecret) {
        $applicationConext = null;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->debug = getenv("BC_DEBUG") != null;
        $this->credential = new Credential($this, $endpoint);
        $this->bitcasaClientApi = new BitcasaApi($this->credential);
    }

    /**
     * Authenticates with bitcasa.
     *
     * @param string $username The username.
     * @param string $password The password.
     * @return The authentication status.
     */
    public function authenticate($username, $password) {
        $api = $this->getClientApi();
        $resp = $api->getAccessToken($this, $username, $password);
        if ($this->debug) {
            print "auth result: "; var_dump($resp);
        }
        return ($resp != null && isset($resp['access_token']));
    }

    /**
     * Retrieves the bitcasa client api.
     *
     * @return The bitcasa client api.
     */
    public function getClientApi() {
        return $this->bitcasaClientApi;
    }

    /**
     * Determines whether a valid security token exists.
     *
     * @return Boolean value indicating the validity of the security token.
     */
    public function isLinked() {
        if ($this->credential->getAccessToken() == null)
            return false;
        else
            return true;
    }

    /**
     * Removes the security token.
     */
    public function unlink() {
        $this->credential->setAccessToken(null);
        $this->credential->setTokenType(null);
    }

    /**
     * Retrieves the user information.
     *
     * @throws IOException
     * @throws BitcasaException
     * @return Current Bitcasa User information
     */
    public function user() {
        $connection = new HTTPConnect($this);
        $url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_USER . BitcasaConstants::METHOD_PROFILE);
        if (!BitcasaUtils::isSuccess($connection->get($url))) {
            return null;
        }

        $response = $connection->getResponse(true);

        $user = User::getInstance($response);
        return $user;
    }

    /**
     * Retrieves the account information.
     *
     * @throws IOException
     * @throws mixed BitcasaException
     * @return Current Bitcasa Account information
     */
    public function account() {
        $connection = new HTTPConnect($this);
        $url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_USER . BitcasaConstants::METHOD_PROFILE);
        if (!BitcasaUtils::isSuccess($connection->get($url))) {
            return null;
        }

        $response = $connection->getResponse(true);

        $accountInfo = Account::getInstance($response);
        return $accountInfo;
    }

    /**
     * Retrieves the bitcasa filesystem.
     *
     * @return The bitcasa filesystem
     */
    public function fileSystem() {
        return new Filesystem($this->bitcasaClientApi);
    }

    /**
     * Retrieves the session client id.
     *
     * @return The client id.
     */
    public function getClientId() {
        return $this->clientId;
    }

    /**
     * Set the session client id.
     *
     * @param string $clientId The client Id to be set.
     */
    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }

    /**
     * Retrieves the session client secret.
     *
     * @return The client secret.
     */
    public function getClientSecret() {
        return $this->clientSecret;
    }

    /**
     * Sets the session client secret.
     *
     * @param string $clientSecret The client secret to be set.
     */
    public function setClientSecret($clientSecret) {
        $this->clientSecret = $clientSecret;
    }

    /**
     * Retrieves the sessions bitcasa client api.
     *
     * @return The bitcasa client api.
     */
    public function getBitcasaClientApi() {
        return $this->bitcasaClientApi;
    }

    /**
     * Sets the sessions bitcasa client api.
     *
     * @param BitcasaClientApi $bitcasaClientApi The bitcasa client api to be set.
     */
    public function setBitcasaClient(BitcasaClientApi $bitcasaClientApi) {
        $this->bitcasaClientApi = $bitcasaClientApi;
    }

    /**
     * Retrieves the access token.
     *
     * @return The access token.
     */
    public function getAccessToken() {
        return $this->credential->getAccessToken();
    }

    /**
     * Retrieves the file history of a given item.
     *
     * @param string $path The path of the item for which the file history needs to be retrieved.
     * @param int $start Start version.
     * @param int $stop Stop version.
     * @param int $limit The limit of history entries.
     * @return File history entries.
     * @throws InvalidArgument
     */
    public function actionHistory($path, $start = 0, $stop = 0, $limit = 0) {
        //assert_string($path, 1);
        $connection = new HTTPConnect($this);
        $params = array();
        if ($start != 0) {
            $params['start'] = $start;
        }
        if ($stop != 0) {
            $params['stop'] = $stop;
        }
        if ($limit != 0) {
            $params['limit'] = $limit;
        }
        $url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FILES, $path . "/versions",
            $params);
        if ($connection->get($url) <= 100) {
            return false;
        }

        return $connection->getResponse(true);
    }

    /**
     * Sets the admin credentials.
     *
     * @param string $adminClientId The admin client id for the bitcasa account.
     * @param string $adminSecret The admin secret for the bitcasa account.
     */
    public function setAdminCredentials($adminClientId, $adminSecret) {
        $this->adminClientId = $adminClientId;
        $this->adminClientSecret = $adminSecret;
    }

    /**
     * Creates a bitcasa user with the specified details.
     *
     * @param string $username The username.
     * @param string $password The password.
     * @param string $email The email.
     * @param string $firstName The user first name.
     * @param string $lastName The user last name.
     * @param bool $logInToCreatedUser Boolean value indicating whether to login with the created user credentials.
     * @return The created user instance.
     * @throws InvalidArgumentException
     */
    public function createAccount($username, $password, $email = null, $firstName = null,
                                  $lastName = null, $logInToCreatedUser = false) {
        $user = null;
        if (empty($username)) {
            throw new InvalidArgumentException('createAccount function accepts a valid username. Input was ' . $username);
        }
        else if(empty($password)) {
            throw new InvalidArgumentException('createAccount function accepts a valid password. Input was ' . $password);
        }
        else {
            $connection = new HTTPConnect($this);

            $formParameters = array('password' => urlencode($password), 'username' => urlencode($username));
            if (!empty($email)) {
                $formParameters['email'] = $email;
            }

            if (!empty($firstName)) {
                $formParameters['first_name'] = $firstName;
            }

            if (!empty($lastName)) {
                $formParameters['last_name'] = $lastName;
            }

            $url = 'https://access.bitcasa.com/v2/admin/cloudfs/customers/';

            $url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_ADMIN .
                BitcasaConstants::METHOD_CLOUDFS.
                BitcasaConstants::METHOD_CUSTOMERS);

            $authorizationDate = strftime(BitcasaConstants::DATE_FORMAT, time()); // gmdate("D, d M Y H:i:s T", time());
            $authorizationParameters = BitcasaUtils::generateParamsString($formParameters);
            $authorizationUrl = BitcasaConstants::API_VERSION_2 . BitcasaConstants::METHOD_ADMIN .
                BitcasaConstants::METHOD_CLOUDFS . BitcasaConstants::METHOD_CUSTOMERS;
            $authorizationValue = BitcasaUtils::generateAuthorizationValue($this, $authorizationUrl,
                $authorizationParameters, $authorizationDate);

            $connection->addHeader(BitcasaConstants::HEADER_AUTORIZATION, $authorizationValue);
            $connection->addHeader(BitcasaConstants::HEADER_CONTENT_TYPE, BitcasaConstants::FORM_URLENCODED);
            $connection->addHeader(BitcasaConstants::HEADER_DATE, $authorizationDate);

            $connection->setData($authorizationParameters);
            $status = $connection->post($url);

            if (BitcasaUtils::isSuccess($status)) {
                $resp = $connection->getResponse(true, false);
                $debug = '';
            }



//            $connection = new HTTPConnect($this->credential->getSession());
//            $url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_ADMIN .
//                BitcasaConstants::METHOD_CLOUDFS.
//                BitcasaConstants::METHOD_CUSTOMERS);
//
//            $formParameters = array('username' => $username, 'password' => $password);
//            if (!empty($email)) {
//                $formParameters['email'] = $email;
//            }
//
//            if (!empty($firstName)) {
//                $formParameters['first_name'] = $firstName;
//            }
//
//            if (!empty($lastName)) {
//                $formParameters['last_name'] = $lastName;
//            }
//
//            $connection->setData(BitcasaUtils::generateParamsString($formParameters));
//            $status = $connection->post($url);
//            $response = $connection->getResponse(true);
//            if (!empty($response) && !empty($response['result'])) {
//                $user = User::getInstance($response['result']);
//
//                if($logInToCreatedUser)
//                {
//                    $this->authenticate($username, $password);
//                }
//            }
        }

        return $user;
    }
}