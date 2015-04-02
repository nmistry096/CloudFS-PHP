-------------
CloudFS\\User
-------------

.. php:namespace: CloudFS

.. php:class:: User

    Represents a bitcasa cloudfs user.

    .. php:method:: getEmail()

        Retrieves the user email

        :returns: The user email.

    .. php:method:: getFirstName()

        Retrieves the users first name.

        :returns: The users first name.

    .. php:method:: getLastName()

        Retrieves the users last name.

        :returns: The users last name.

    .. php:method:: getId()

        Retrieves the user id.

        :returns: The user id.

    .. php:method:: getUsername()

        Retrieves the users user name.

        :returns: The users username.

    .. php:method:: getLastLogin()

        Retrieves the users last login timestamp.

        :returns: The users last login timestamp.

    .. php:method:: getCreatedAt()

        Retrieves the user created timestamp.

        :returns: The user created timestamp.

    .. php:method:: __construct()

        Private constructor to avoid creating new share objects.

    .. php:method:: getInstance($data)

        Retrieves a user instance from the supplied result.

        :type $data: mixed
        :param $data: The json response retrieved from rest api.
        :returns: A user instance.
