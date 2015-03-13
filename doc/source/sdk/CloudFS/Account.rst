----------------
CloudFS\\Account
----------------

.. php:namespace: CloudFS

.. php:class:: Account

    Represents a bitcasa cloudfs account.

    .. php:method:: getId()

        Retrieves the account id.

        :returns: The retrieved account id.

    .. php:method:: getStorageUsage()

        Retrieves the storage amount used.

        :returns: The used storage amount.

    .. php:method:: getStorageLimit()

        Retrieves the storage limit.

        :returns: The storage limit.

    .. php:method:: getOverStorageLimit()

        Retrieves the over storage limit of account.

        :returns: The over storage limit.

    .. php:method:: getStateDisplayName()

        Retrieves the account state display name.

        :returns: The account state display name.

    .. php:method:: getStateId()

        Retrieves the account state id.

        :returns: The account state id.

    .. php:method:: getPlanDisplayName()

        Retrieves the account plan display name.

        :returns: The account plan display name.

    .. php:method:: getPlanId()

        Retrieves the account plan id.

        :returns: The account plan id.

    .. php:method:: getSessionLocale()

        Retrieves the session locale.

        :returns: The session locale.

    .. php:method:: getAccountLocale()

        Retrieves the account locale.

        :returns: The account locale.

    .. php:method:: __construct()

        The account construct.

    .. php:method:: getInstance($data)

        Retrieves an account instance from the supplied data.

        :type $data: mixed
        :param $data: The retrieved data.
        :returns: An account instance.
