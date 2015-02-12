-------
Session
-------

.. php:namespace:

.. php:class:: Session

    Defines a bitcasa session.

    .. php:method:: __construct($endpoint, $clientId, $clientSecret)

        Initializes the Session instance.

        :param $endpoint:
        :param $clientId:
        :param $clientSecret:

    .. php:method:: authenticate($username, $password)

        Authenticates with bitcasa.

        :param $username:
        :param $password:
        :returns: bool

    .. php:method:: getClientApi()

        Retrieves the bitcasa client api.

        :returns: The bitcasa client api.

    .. php:method:: isLinked()

        Retrieves the linked status of the app with bitcasa.

        :returns: The linked status.

    .. php:method:: unlink()

        Unlink the app with bitcasa.

    .. php:method:: user()

        Retrieves the user information from bitcasa.
        This method requires a request to network

        :returns: Current Bitcasa User information

    .. php:method:: account()

        Retrieves the account information from bitcasa.
        This method requires a request to network

        :returns: current Bitcasa Account information

    .. php:method:: filesystem()

        Retrieves the bitcasa filesystem.

        :returns: The bitcasa filesystem

    .. php:method:: getClientId()

        Retrieves the session client id.

        :returns: The client id.

    .. php:method:: setClientId($clientId)

        Set the session client id.

        :param $clientId:

    .. php:method:: getClientSecret()

        Retrieves the session client secret.

        :returns: The client secret.

    .. php:method:: setClientSecret($clientSecret)

        Sets the session client secret.

        :param $clientSecret:

    .. php:method:: getBitcasaClientApi()

        Retrieves the sessions bitcasa client api.

        :returns: The bitcasa client api.

    .. php:method:: setBitcasaClient(BitcasaClientApi $bitcasaClientApi)

        Sets the sessions bitcasa client api.

        :type $bitcasaClientApi: BitcasaClientApi
        :param $bitcasaClientApi: The bitcasa client api to be set.

    .. php:method:: getAccessToken()

        Retrieves the access token.

        :returns: The access token.
