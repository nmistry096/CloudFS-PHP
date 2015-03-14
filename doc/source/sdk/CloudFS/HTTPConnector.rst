----------------------
CloudFS\\HTTPConnector
----------------------

.. php:namespace: CloudFS

.. php:class:: HTTPConnector

    .. php:attr:: curl

    .. php:attr:: boundary

    .. php:attr:: eof

    .. php:attr:: postdata

    .. php:method:: __construct($session = null)

        Initializes the http connect instance.

        :type $session: Session
        :param $session: The http session instance.

    .. php:method:: raw()

        Sets the raw flag of the http request.

    .. php:method:: addHeader($h, $v)

        Adds the specified http header to the http request.

        :type $h: string
        :param $h: The specified http header.
        :type $v: string
        :param $v: The http header value to be added.

    .. php:method:: addMissingHeader($h, $v)

        Adds the specified http header to the http request if it's missing.

        :type $h: string
        :param $h: The specified http header.
        :type $v: string
        :param $v: The http header value to be added.
        :returns: Flag whether the operation was successful.

    .. php:method:: hasHeader($h, $value = null)

        Retrieves whether the http request has the specified http header.

        :type $h: string
        :param $h: The specified http header.
        :type $value: string
        :param $value: The specified http header value.
        :returns: The flag as to whether the http request has the specified header.

    .. php:method:: getHeaders()

        Retrieves the header of an http request.

        :returns: The header result array.

    .. php:method:: setData($data, $len = 0)

        Sets the data and the data length of the http request.

        :type $data: mixed
        :param $data: The data to be added to the http request.
        :type $len: int
        :param $len: The length of the added data.

    .. php:method:: post($url)

        Posts the http request to a given url.

        :type $url: string
        :param $url: The url for the http post.
        :returns: The posts http status.

    .. php:method:: download($url, $localDestinationPath, $downloadProgressCallback)

        Downloads the file at specified url.

        :type $url: string
        :param $url: The url for the resource.
        :type $localDestinationPath: string
        :param $localDestinationPath: The path of the local file to download the content.
        :type $downloadProgressCallback: mixed
        :param $downloadProgressCallback: The download progress callback function. This function should take 'downloadSize', 'downloadedSize', 'uploadSize', 'uploadedSize' as arguments.
        :returns: The response status.

    .. php:method:: readFunction($curl, $fd, $length)

        Reads and retrieves the data of the http request.

        :type $curl: mixed
        :param $curl: The curl commands.
        :param $fd:
        :type $length: int
        :param $length: Variable to retrieve the http request data of a given length.
        :returns: The http request data.

    .. php:method:: postMultipart($url, $name, $path, $exists, $uploadProgressCallback = null)

        Posts the http request with multiple parts to a given url.

        :type $url: string
        :param $url: The url for the http post.
        :type $name: string
        :param $name: The filename to be posted.
        :type $path: string
        :param $path: The path of the item to be posted.
        :type $exists: string
        :param $exists: Specifies action to take if item exists.
        :type $uploadProgressCallback: mixed
        :param $uploadProgressCallback: The upload progress callback function. This function should take 'downloadSize', 'downloadedSize', 'uploadSize', 'uploadedSize' as arguments.
        :returns: The posts http status.

    .. php:method:: put($url)

        Carries out a put http request on the given url.

        :type $url: string
        :param $url: The url for the http put.
        :returns: The put operations http status.

    .. php:method:: get($url)

        Carries out a get http request on the given url.

        :type $url: string
        :param $url: The url for the get request.
        :returns: The get operations http status.

    .. php:method:: head($url)

        Carries out a head http request on the given url.

        :type $url: string
        :param $url: The url for the head request.
        :returns: The head operations http status.

    .. php:method:: delete($url)

        Carries out a delete http request on the given url.

        :type $url: string
        :param $url: The url for the delete operation.
        :returns: The delete operations http status.

    .. php:method:: getResponse($json = false, $check = true)

        Returns the response for the http request.

        :type $json: bool
        :param $json: Json received as response.
        :type $check: bool
        :param $check: Flag to check the response with bitcasa status.
        :returns: The http response.

    .. php:method:: setUserAgent($agent)

        Sets the user agent of the http operation.

        :type $agent: string
        :param $agent: The user agent.

    .. php:method:: getUserAgent()

        Retrieves the user agent of the http operation.

        :returns: The user agent.

    .. php:method:: process($url)

        Validates and processes the http request.

        :type $url: string
        :param $url: The url variable for curl operations.

    .. php:method:: setup()

        Setup the http request adding the necessary headers and the access token.
