------------
BitcasaUtils
------------

.. php:namespace:

.. php:class:: BitcasaUtils

    Bitcasa Client PHP SDK
    Copyright (C) 2014 Bitcasa, Inc.

    This file contains an SDK in PHP for accessing the Bitcasa infinite drive.

    For support, please send email to support@bitcasa.com.

    .. php:method:: isSuccess($status)

        Retrieves if a status code is successful or not.

        :param $status:
        :returns: bool Flag whether the operation was successful.

    .. php:method:: getRequestUrl($credential, $request, $method = NULL, $queryParams = NULL)

        :param $credential:
        :param $request:
        :param $method:
        :param $queryParams:

    .. php:method:: generateParamsString($params)

        Generate the parameter strings for a request url given an array of
        parameters.

        :param $params:
        :returns: The parameter string.

    .. php:method:: replaceSpaceWithPlus($s)

        Replaces the spaces of a given string with '+'s.

        :param $s:
        :returns: The formatted string.

    .. php:method:: hex2base64($hex)

        Encodes the given data with MIME base64.

        :param $hex:
        :returns: The encoded data.

    .. php:method:: sha1($s, $secret)

        Hashes the given data in SHA1 format.

        :param $s:
        :param $secret:
        :returns: The hashed data.

    .. php:method:: generateAuthorizationValue($session, $uri, $params, $date)

        Generate the authorization value for the given session and parameters.

        :param $session:
        :param $uri:
        :param $params:
        :param $date:
        :returns: The authorization value.
