---------------------
CloudFS\\BitcasaUtils
---------------------

.. php:namespace: CloudFS

.. php:class:: BitcasaUtils

    .. php:method:: isSuccess($status)

        Retrieves if a status code is successful or not.

        :type $status: int
        :param $status: Status code to evaluate.
        :returns: bool Flag whether the operation was successful.

    .. php:method:: getRequestUrl($credential, $request, $method = NULL, $queryParams = NULL)

        Retrieves the request url for making bitcasa api calls.

        :type $credential: Credential
        :param $credential: Credentials for the bitcasa account.
        :type $request: string
        :param $request: Request parameters for api call.
        :type $method: string
        :param $method: Request method variable.
        :type $queryParams: array
        :param $queryParams: Query parameters for the api call.
        :returns: The request url.

    .. php:method:: generateParamsString($params)

        Generate the parameter strings for a request url given an array of
        parameters.

        :type $params: array
        :param $params: The parameter array to be converted in to a parameter string.
        :returns: The parameter string.

    .. php:method:: replaceSpaceWithPlus($s)

        Replaces the spaces of a given string with '+'s.

        :type $s: string
        :param $s: The string to be formatted.
        :returns: The formatted string.

    .. php:method:: hex2base64($hex)

        Encodes the given data with MIME base64.

        :type $hex: mixed
        :param $hex: The data to be encoded.
        :returns: The encoded data.

    .. php:method:: sha1($s, $secret)

        Hashes the given data in SHA1 format.

        :type $s: mixed
        :param $s: The data to be encoded.
        :type $secret: string
        :param $secret: The secret key used for hashing.
        :returns: The hashed data.

    .. php:method:: generateAuthorizationValue($session, $uri, $params, $date)

        Generate the authorization value for the given session and parameters.

        :type $session: Session
        :param $session: The session instance.
        :type $uri: string
        :param $uri: The request uri.
        :type $params: string
        :param $params: Request parameters.
        :type $date: string
        :param $date: Date of the request.
        :returns: The authorization value.

    .. php:method:: generateAdminAuthorizationValue($session, $uri, $params, $date)

        Generate the admin authorization value for the given session and
        parameters.

        :type $session: Session
        :param $session: The session instance.
        :type $uri: string
        :param $uri: The request uri.
        :type $params: string
        :param $params: Request parameters.
        :type $date: string
        :param $date: Date of the request.
        :returns: The authorization value.

    .. php:method:: getParentPath($path)

        Gets the parent path from the specified item path.

        :param $path:
        :returns: The parent path.
