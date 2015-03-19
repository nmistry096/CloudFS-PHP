-------------------
CloudFS\\Filesystem
-------------------

.. php:namespace: CloudFS

.. php:class:: Filesystem

    Defines the Bitcasa file system.

    .. php:method:: __construct($restAdapter)

        Initialize the Filesystem instance.

        :type $restAdapter: \CloudFS\RESTAdapter
        :param $restAdapter: The restAdapter instance.

    .. php:method:: root()

        Retrieves the root directory.

        :returns: The root directory.

    .. php:method:: listTrash()

        Browses the Trash meta folder on the authenticated user’s account.

    .. php:method:: getItem($path)

        Retrieves an item by the given path.

        :type $path: string
        :param $path: The item path.
        :returns: An instance of the item.

    .. php:method:: listShares()

        Retrieves the list of shares on the filesystem.

        :returns: The share list.

    .. php:method:: createShare($path, $password = null)

        Create a share of an item at the supplied path.

        :type $path: string
        :param $path: The path of the item to be shared.
        :type $password: string
        :param $password: The password of the shared to be created.
        :returns: An instance of the share.

    .. php:method:: retrieveShare($shareKey, $password = null)

        Retrieves the shared item for the specified key.

        :type $shareKey: string
        :param $shareKey: The share key.
        :type $password: string
        :param $password: The password for the share.
        :returns: An instance of share.
