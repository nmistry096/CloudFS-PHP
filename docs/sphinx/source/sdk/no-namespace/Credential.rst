----------
Credential
----------

.. php:namespace:

.. php:class:: Credential

    Defines the credential properties.

    .. php:method:: __construct($session = null, $endpoint = NULL)

        Initializes the Credentials instance.

        :type $session: null
        :param $session:
        :type $endpoint: null
        :param $endpoint:

    .. php:method:: getEndPoint()

        Retrieves the credentials api endpoint.

        :returns: The api endpoint.

    .. php:method:: getApplicationContext()

        Retrieves the credentials application context.

        :returns: The application context.

    .. php:method:: getAccessToken()

        Retrieves the credentials access token.

        :returns: The access token.

    .. php:method:: setAccessToken($token)

        Sets the credentials access token.

        :param $token:

    .. php:method:: getTokenType()

        Retrieves the credential token type.

        :returns: The token type.

    .. php:method:: setTokenType($type)

        Sets the credential token type.

        :param $type:

    .. php:method:: getRequestUrl($method, $operation = null, $params = null)

        Retrieves the request url for credentials.

        :param $method:
        :type $operation: null
        :param $operation: Request url operation.
        :type $params: null
        :param $params: Parameters for request url.
        :returns: The request url.

    .. php:method:: getSession()

        Retrieves the credential session.

        :returns: null
