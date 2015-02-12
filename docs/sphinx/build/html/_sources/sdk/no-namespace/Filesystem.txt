----------
Filesystem
----------

.. php:namespace:

.. php:class:: Filesystem

    Represents the Bitcasa file system information.

    .. php:method:: __construct($api)

        Initialize the Filesystem instance.

        :param $api:

    .. php:method:: getList($dir = null)

        Retrieves the item array for a given directory.

        :type $dir: null
        :param $dir: The directory for which the items should be retrieved for, if empty root items are retrieved.
        :returns: The array of items at the given directory.

    .. php:method:: getFile($path)

        Retrieves an item by the given path.

        :param $path:
        :returns: An instance of the item of type Audio|Document|Photo|Video|File.

    .. php:method:: getFolder($path)

        Retrieves a folder by the given path.

        :param $path:
        :returns: An instance of the item of type Folder.

    .. php:method:: delete($items, $force = false)

        Delete multiple items from cloud storage.

        :param $items:
        :type $force: bool
        :param $force: The flag to force delete items from cloud storage.
        :returns: The success/fail response of the delete operation.

    .. php:method:: create($parent, $name, $exists = "overwrite")

        Create a folder with supplied name under the given parent folders,
        folder path.

        :param $parent:
        :param $name:
        :type $exists: string
        :param $exists: Specifies the action to take if the folder already exists.
        :returns: An instance of the newly created item of type Folder.

    .. php:method:: move($items, $destination, $exists = "fail")

        Moves multiple items to a specified destination.

        :param $items:
        :param $destination:
        :type $exists: string
        :param $exists: Specifies the action to take if the item already exists.
        :returns: The success/fail response of the move operation

    .. php:method:: copy($items, $destination, $exists = "fail")

        Copy multiple items to a specified destination.

        :param $items:
        :param $destination:
        :type $exists: string
        :param $exists: Specifies the action to take if the item already exists.
        :returns: The success/fail response of the copy operation

    .. php:method:: save($items, $conflict = "fail")

        Update items on the cloud file system.

        :param $items:
        :type $conflict: string
        :param $conflict: The action to take if a conflict occurs.
        :returns: The success/fail response of the update operation.

    .. php:method:: upload($parent, $path, $name = null, $exists = "overwrite")

        Upload a file on to the given path.

        :param $parent:
        :param $path:
        :param $name:
        :type $exists: string
        :param $exists: The action to take if the item already exists.
        :returns: An instance of the uploaded item.

    .. php:method:: download($item, $file = null)

        Download an item from the cloud storage.

        :param $item:
        :type $file: null
        :param $file:

    .. php:method:: restore($items, $destination, $exists)

        Restore a given set of items to the supplied destination.

        :param $items:
        :param $destination:
        :param $exists:
        :returns: The success/fail response of the restore operation.

    .. php:method:: fileHistory($item, $start = -10, $stop = 0)

        Retrieves the file history of a given item.

        :param $item:
        :type $start: int
        :param $start:
        :type $stop: int
        :param $stop:
        :returns: File history entries.
