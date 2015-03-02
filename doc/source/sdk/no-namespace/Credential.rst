----------
Credential
----------

.. php:namespace:

.. php:class:: Credential

    Defines the credential properties.

    .. php:method:: __construct($session = null, $endpoint = NULL)

        Initializes the Credentials instance.

        :type $session: Session
        :param $session: Session variable.
        :type $endpoint: string
        :param $endpoint: The bitcasa endpoint.

    .. php:method:: getEndPoint()

        Retrieves the credentials api endpoint.

        :returns: The api endpoint.

    .. php:method:: getApplicationContext()

        Retrieves the application context.

        :returns: The application context.

    .. php:method:: getAccessToken()

        Retrieves the credentials access token.

        :returns: The access token.

    .. php:method:: setAccessToken($token)

        Sets the credentials access token.

        :type $token: string
        :param $token: The access token to be set.

    .. php:method:: getTokenType()

        Retrieves the credential token type.

        :returns: The token type.

    .. php:method:: setTokenType($type)

        Sets the credential token type.

        :type $type: string
        :param $type: The token type to be set.

    .. php:method:: getRequestUrl($method, $operation = null, $params = null)

        Retrieves the request url for credentials.

        :type $method: string
        :param $method: Request url method variable.
        :type $operation: string
        :param $operation: Request url operation.
        :type $params: mixed
        :param $params: Parameters for request url.
        :returns: string The request url.

    .. php:method:: getSession()

        Retrieves the credential session.

        :returns: The session.
