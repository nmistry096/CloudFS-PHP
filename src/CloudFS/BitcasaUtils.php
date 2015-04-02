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

use CloudFS\Utils\BitcasaConstants;

abstract class BitcasaUtils {

    /**
     * Retrieves if a status code is successful or not.
     *
     * @param int $status Status code to evaluate.
     * @return bool Flag whether the operation was successful.
     */
    public static function isSuccess($status) {
        return $status >= 200 && $status < 300;
    }

    /**
     * Retrieves the request url for making bitcasa api calls.
     *
     * @param Credential $credential Credentials for the bitcasa account.
     * @param string $request Request parameters for api call.
     * @param string $method Request method variable.
     * @param array $queryParams Query parameters for the api call.
     * @return The request url.
     */
    public static function getRequestUrl($credential, $request, $method = NULL, $queryParams = NULL) {
        $url = BitcasaConstants::HTTPS;
        $url .= $credential->getEndPoint();
        $url .= BitcasaConstants::API_VERSION_2;
        $url .= $request;

        if ($method != null)
            $url .= $method;

        if ($queryParams != null) {
            $url .= "?";
            $url .= BitcasaUtils::generateParamsString($queryParams);
        }

        return $url;
    }

    /**
     * Generate the parameter strings for a request url given an array of parameters.
     *
     * @param array $params The parameter array to be converted in to a parameter string.
     * @return The parameter string.
     */
    public static function generateParamsString($params) {
        $paramsString = "";
        $first = true;
        if ($params != null && count($params) > 0) {
            foreach ($params as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $index => $data) {
                        if ($index > 0) {
                            $paramsString .= "&";
                        }
                        $paramsString .= $key . "=" . BitcasaUtils::replaceSpaceWithPlus($data);
                    }
                } else {

                    if ($first == true) {
                        $first = false;
                    } else {
                        $paramsString .= "&";
                    }

                    $paramsString .= $key . "=" . BitcasaUtils::replaceSpaceWithPlus($value);
                }

            }
        }
        return $paramsString;
    }

    /**
     * Replaces the spaces of a given string with '+'s.
     *
     * @param string $s The string to be formatted.
     * @return The formatted string.
     */
    public static function replaceSpaceWithPlus($s) {
        return str_replace(" ", "+", $s);
    }

    /**
     * Encodes the given data with MIME base64.
     *
     * @param mixed $hex The data to be encoded.
     * @return The encoded data.
     */
    public static function hex2base64($hex) {
        return base64_encode(pack("H*", $hex));
    }

    /**
     * Hashes the given data in SHA1 format.
     *
     * @param mixed $s The data to be encoded.
     * @param string $secret The secret key used for hashing.
     * @return The hashed data.
     */
    public static function sha1($s, $secret) {
        return BitcasaUtils::hex2base64(hash_hmac('sha1', $s, $secret));
    }

    /**
     * Generate the authorization value for the given session and parameters.
     *
     * @param Session $session The session instance.
     * @param string $uri The request uri.
     * @param string $params Request parameters.
     * @param string $date Date of the request.
     * @return The authorization value.
     */
    public static function generateAuthorizationValue($session, $uri, $params, $date) {
        $stringToSign = "";
        $stringToSign .= BitcasaConstants::REQUEST_METHOD_POST . "&" . $uri . "&" . $params . "&";
        $stringToSign .= BitcasaUtils::replaceSpaceWithPlus(urlencode(BitcasaConstants::HEADER_CONTENT_TYPE)) . ":";
        $stringToSign .= BitcasaUtils::replaceSpaceWithPlus(urlencode(BitcasaConstants::FORM_URLENCODED)) . "&";
        $stringToSign .= BitcasaUtils::replaceSpaceWithPlus(urlencode(BitcasaConstants::HEADER_DATE)) . ":";
        $stringToSign .= BitcasaUtils::replaceSpaceWithPlus(urlencode($date));

        $authorizationValue = "BCS " . $session->getClientId() . ":";
        $authorizationValue .= BitcasaUtils::sha1($stringToSign, $session->getClientSecret());

        return $authorizationValue;
    }

    /**
     * Generate the admin authorization value for the given session and parameters.
     *
     * @param Session $session The session instance.
     * @param string $uri The request uri.
     * @param string $params Request parameters.
     * @param string $date Date of the request.
     * @return The authorization value.
     */
    public static function generateAdminAuthorizationValue($session, $uri, $params, $date) {
        $stringToSign = "";
        $stringToSign .= BitcasaConstants::REQUEST_METHOD_POST . "&" . $uri . "&" . $params . "&";
        $stringToSign .= BitcasaUtils::replaceSpaceWithPlus(urlencode(BitcasaConstants::HEADER_CONTENT_TYPE)) . ":";
        $stringToSign .= BitcasaUtils::replaceSpaceWithPlus(urlencode(BitcasaConstants::FORM_URLENCODED)) . "&";
        $stringToSign .= BitcasaUtils::replaceSpaceWithPlus(urlencode(BitcasaConstants::HEADER_DATE)) . ":";
        $stringToSign .= BitcasaUtils::replaceSpaceWithPlus(urlencode($date));

        $authorizationValue = "BCS " . $session->getAdminClientId() . ":";
        $authorizationValue .= BitcasaUtils::sha1($stringToSign, $session->getAdminClientSecret());

        return $authorizationValue;
    }

    /**
     * Gets the parent path from the specified item path.
     *
     * @param $path The path of the item.
     * @return The parent path.
     */
    public static function getParentPath($path) {
        $parentPath = $path;
        if ($path == null) {
            $parentPath = "/";
        }
        if ($path != "/") {
            $pathItems = explode("/", $path);
            if (count($pathItems) <= 2) {
                $parentPath = "/";
            } else {
                array_pop($pathItems);
                $parentPath = implode("/", $pathItems);
            }
        }

        return $parentPath;
    }

}

?>
