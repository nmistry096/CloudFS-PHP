-----------
HTTPConnect
-----------

.. php:namespace:

.. php:class:: HTTPConnect

    .. php:attr:: curl

    .. php:attr:: boundary

    .. php:attr:: eof

    .. php:attr:: postdata

    .. php:method:: HTTPConnect($session = null)

        Initializes the http connect instance.

        :type $session: null
        :param $session: The http session instance.

    .. php:method:: raw()

        Sets the raw flag of the http request.

    .. php:method:: addHeader($h, $v)

        Adds the specified http header to the http request.

        :param $h:
        :param $v:

    .. php:method:: addMissingHeader($h, $v)

        Adds the specified http header to the http request if it's missing.

        :param $h:
        :param $v:
        :returns: bool Flag whether the operation was successful.

    .. php:method:: hasHeader($h, $value = null)

        Retrieves whether the http request has the specified http header.

        :param $h:
        :type $value: null
        :param $value: The specified http header value.
        :returns: bool The flag as to whether the http request has the specified header.

    .. php:method:: getHeaders()

        Retrieves the header of an http request.

        :returns: array

    .. php:method:: sendData($data, $len = 0)

        Sets the data and the data length of the http request.

        :param $data:
        :type $len: int
        :param $len: The length of the added data.

    .. php:method:: post($url)

        Posts the http request to a given url.

        :param $url:
        :returns: The posts http status.

    .. php:method:: read_function($curl, $fd, $length)

        Reads and retrieves the data of the http request.

        :param $curl:
        :param $fd:
        :param $length:
        :returns: The http request data.

    .. php:method:: post_multipart($url, $name, $path, $exists)

        Posts the http request with multiple parts to a given url.

        :param $url:
        :param $name:
        :param $path:
        :param $exists:
        :returns: unknown The posts http status.

    .. php:method:: put($url)

        Carries out a put http request on the given url.

        :param $url:
        :returns: unknown  The put operations http status.

    .. php:method:: get($url)

        Carries out a get http request on the given url.

        :param $url:
        :returns: The get operations http status.

    .. php:method:: head($url)

        Carries out a head http request on the given url.

        :param $url:
        :returns: unknown The head operations http status.

    .. php:method:: delete($url)

        Carries out a delete http request on the given url.

        :param $url:
        :returns: unknown The delete operations http status.

    .. php:method:: getResponse($json = false, $check = true)

        Returns the response for the http request.

        :type $json: bool
        :param $json: Json received as response.
        :type $check: bool
        :param $check: Flag to check the response with bitcasa status.
        :returns: The http response.

    .. php:method:: setUserAgent($agent)

        Sets the user agent of the http operation.

        :param $agent:

    .. php:method:: getUserAgent()

        Retrieves the user agent of the http operation.

        :returns: The user agent.

    .. php:method:: process($url)

        Validates and processes the http request.

        :param $url:

    .. php:method:: setup()

        Setup the http request adding the necessary headers and the access token.
