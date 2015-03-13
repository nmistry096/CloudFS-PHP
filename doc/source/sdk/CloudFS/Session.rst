----------------
CloudFS\\Session
----------------

.. php:namespace: CloudFS

.. php:class:: Session

    Defines a bitcasa session.

    .. php:const:: ADMIN_END_POINT

        The admin base url.

    .. php:method:: __construct($endpoint, $clientId, $clientSecret)

        Initializes the Session instance.

        :type $endpoint: string
        :param $endpoint: The bitcasa api end point.
        :type $clientId: string
        :param $clientId: The app client id.
        :type $clientSecret: string
        :param $clientSecret: The app client secret.

    .. php:method:: authenticate($username, $password)

        Authenticates with bitcasa.

        :type $username: string
        :param $username: The username.
        :type $password: string
        :param $password: The password.
        :returns: The authentication status.

    .. php:method:: getClientApi()

        Retrieves the bitcasa client api.

        :returns: The bitcasa client api.

    .. php:method:: filesystem()

        Gets a file system instance.

        :returns: A file system instance.

    .. php:method:: isLinked()

        Determines whether a valid security token exists.

        :returns: Boolean value indicating the validity of the security token.

    .. php:method:: unlink()

        Removes the security token.

    .. php:method:: user()

        Retrieves the user information.

        :returns: Current Bitcasa User information

    .. php:method:: account()

        Retrieves the account information.

        :returns: Current Bitcasa Account information

    .. php:method:: getClientId()

        Retrieves the session client id.

        :returns: The client id.

    .. php:method:: getClientSecret()

        Retrieves the session client secret.

        :returns: The client secret.

    .. php:method:: getBitcasaClientApi()

        Retrieves the sessions bitcasa client api.

        :returns: The bitcasa client api.

    .. php:method:: getAccessToken()

        Retrieves the access token.

        :returns: The access token.

    .. php:method:: actionHistory($startVersion = -10, $stopVersion = null)

        Retrieves the action history.

        :type $startVersion: int
        :param $startVersion: Integer representing which version number to start listing historical actions from.
        :type $stopVersion: int
        :param $stopVersion: Integer representing which version number from which to stop listing historical actions.
        :returns: The action history.

    .. php:method:: setAdminCredentials($adminClientId, $adminSecret)

        Sets the admin credentials.

        :type $adminClientId: string
        :param $adminClientId: The admin client id for the bitcasa account.
        :type $adminSecret: string
        :param $adminSecret: The admin secret for the bitcasa account.

    .. php:method:: getAdminClientId()

        Gets the admin client id.

        :returns: The admin client id.

    .. php:method:: getAdminClientSecret()

        Gets the admin client secret.

        :returns: The admin client secret.

    .. php:method:: createAccount($username, $password, $email = null, $firstName = null, $lastName = null, $logInToCreatedUser = false)

        Creates a bitcasa user with the specified details.

        :type $username: string
        :param $username: The username.
        :type $password: string
        :param $password: The password.
        :type $email: string
        :param $email: The email.
        :type $firstName: string
        :param $firstName: The user first name.
        :type $lastName: string
        :param $lastName: The user last name.
        :type $logInToCreatedUser: bool
        :param $logInToCreatedUser: Boolean value indicating whether to login with the created user credentials.
        :returns: The created user instance.
