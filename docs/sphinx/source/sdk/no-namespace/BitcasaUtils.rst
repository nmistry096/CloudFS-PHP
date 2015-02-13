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

        :param $status:

    .. php:method:: getRequestUrl($credential, $request, $method = NULL, $queryParams = NULL)

        :param $credential:
        :param $request:
        :param $method:
        :param $queryParams:

    .. php:method:: generateParamsString($params)

        :param $params:

    .. php:method:: replaceSpaceWithPlus($s)

        :param $s:

    .. php:method:: hex2base64($hex)

        :param $hex:

    .. php:method:: sha1($s, $secret)

        :param $s:
        :param $secret:

    .. php:method:: generateAuthorizationValue($session, $uri, $params, $date)

        :param $session:
        :param $uri:
        :param $params:
        :param $date:
