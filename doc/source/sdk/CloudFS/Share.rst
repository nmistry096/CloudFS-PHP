--------------
CloudFS\\Share
--------------

.. php:namespace: CloudFS

.. php:class:: Share

    .. php:method:: getShareKey()

        Retrieves the  share key.

        :returns: The share key.

    .. php:method:: getShareType()

        Retrieves the  share type.

        :returns: The share type.

    .. php:method:: getName()

        Retrieves the  share name.

        :returns: The share name.

    .. php:method:: getUrl()

        Retrieves the  url.

        :returns: The share url.

    .. php:method:: getShortUrl()

        Retrieves the  short url.

        :returns: The short url.

    .. php:method:: getDateCreated()

        Retrieves the created date.

        :returns: The created date.

    .. php:method:: getSize()

        Retrieves the  share size.

        :returns: The share size.

    .. php:method:: getApplicationData()

        Retrieves the application data.

        :returns: The application data.

    .. php:method:: getDateContentLastModified()

        Retrieves the content last modified date.

        :returns: The content last modified date.

    .. php:method:: getDateMetaLastModified()

        Retrieves the content meta last modified date.

        :returns: The content meta last modified date.

    .. php:method:: __construct()

        Private constructor to avoid creating new share objects.

    .. php:method:: getInstance($fileSystem, $result)

        Retrieves a share instance from the supplied result.

        :param $fileSystem:
        :type $result: mixed
        :param $result: The json response retrieved from rest api.
        :returns: A share instance.

    .. php:method:: getList()

        Lists the items for the share key.

        :returns: The list of items for the share key.

    .. php:method:: delete()

        Deletes the item for the share key.

        :returns: The success/fail response of the delete operation.

    .. php:method:: receive($path = '/', $exists = Exists::RENAME)

        Adds all shared items for the given share key to the path supplied

        :type $path: string
        :param $path: The path to which the share files are added.
        :type $exists: string
        :param $exists: The action to take if the item already exists.
        :returns: bool The success/fail response of the receive operation.

    .. php:method:: changeAttributes($values, $password = null)

        Changes the attributes of a item for the given share key with the supplied
        values.

        :type $values: array
        :param $values: The values to which the attributes are changed to.
        :type $password: null
        :param $password: The password for the change attribute operation.
        :returns: The success/fail response of the change attributes operation.

    .. php:method:: setName($newName, $password = null)

        Sets the name for a given user share.

        :param $newName:
        :type $password: null
        :param $password: The password for the set name operation.
        :returns: The success/fail response of the set name operation.

    .. php:method:: setPassword($newPassword, $oldPassword = null)

        Sets a new password the given user share.

        :param $newPassword:
        :type $oldPassword: null
        :param $oldPassword: The old password for the set password operation.
        :returns: bool The success/fail response of the set password operation.
