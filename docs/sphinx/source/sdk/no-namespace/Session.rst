-------
Session
-------

.. php:namespace:

.. php:class:: Session

    Defines a bitcasa session.

    .. php:method:: __construct($endpoint, $clientId, $clientSecret)

        :param $endpoint:
        :param $clientId:
        :param $clientSecret:

    .. php:method:: authenticate($username, $password)

        Authenticates with the bitcasa.

        :param $username:
        :param $password:
        :returns: bool

    .. php:method:: getClientApi()

    .. php:method:: isLinked()

    .. php:method:: unlink()

    .. php:method:: user()

        This method requires a request to network

        :returns: current Bitcasa User information

    .. php:method:: account()

        This method requires a request to network

        :returns: current Bitcasa Account information

    .. php:method:: filesystem()

    .. php:method:: getClientId()

    .. php:method:: setClientId($clientId)

        :param $clientId:

    .. php:method:: getClientSecret()

    .. php:method:: setClientSecret($clientSecret)

        :param $clientSecret:

    .. php:method:: getBitcasaClientApi()

    .. php:method:: setBitcasaClient(BitcasaClientApi $bitcasaClientApi)

        :type $bitcasaClientApi: BitcasaClientApi
        :param $bitcasaClientApi:

    .. php:method:: getAccessToken()
