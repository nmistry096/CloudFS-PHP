-------------------
CloudFS\\Filesystem
-------------------

.. php:namespace: CloudFS

.. php:class:: Filesystem

    Defines the Bitcasa file system.

    .. php:method:: __construct($api)

        Initialize the Filesystem instance.

        :type $api: object
        :param $api: The api instance.

    .. php:method:: root()

        Retrieves the root directory.

        :returns: The root directory.

    .. php:method:: getList($dir = null)

        Retrieves the item array for a given directory.

        :type $dir: string|null
        :param $dir: The directory path for which the items should be retrieved, if null root items are retrieved.
        :returns: The array of items at the given directory.

    .. php:method:: getItem($path)

        Retrieves an item by the given path.

        :type $path: string
        :param $path: The item path.
        :returns: An instance of the item.

    .. php:method:: getFile($path)

        Retrieves an item by the given path.

        :type $path: string
        :param $path: The file path.
        :returns: An instance of the item of type Audio|Document|Photo|Video|File.

    .. php:method:: getFolder($path)

        Retrieves a folder by the given path.

        :type $path: string
        :param $path: The folder path.
        :returns: A folder instance.

    .. php:method:: delete($items, $force = false)

        Delete multiple items from cloud storage.

        :type $items: Item[]
        :param $items: The array of items to delete.
        :type $force: bool
        :param $force: The flag to force delete items from cloud storage.
        :returns: The success/fail response of the delete operation.

    .. php:method:: create($parent, $name, $exists = "overwrite")

        Create a folder with supplied name under the given parent folders,
        folder path.

        :type $parent: Item
        :param $parent: Folder item under which the new folder should be created.
        :type $name: string
        :param $name: The name of the folder to be created.
        :type $exists: string
        :param $exists: Specifies the action to take if the folder already exists.
        :returns: A folder instance.

    .. php:method:: move($items, $destination, $exists = "fail")

        Moves multiple items to a specified destination.

        :type $items: Item[]
        :param $items: The items to be moved.
        :type $destination: string
        :param $destination: path to which the items should be moved to.
        :type $exists: string
        :param $exists: Specifies the action to take if the item already exists.
        :returns: An associative array containing the items.

    .. php:method:: copy($items, $destination, $exists = "fail")

        Copy multiple items to a specified destination.

        :type $items: Item[]
        :param $items: The items to be copied.
        :type $destination: string
        :param $destination: Path to which the items should be copied to.
        :type $exists: string
        :param $exists: Specifies the action to take if the item already exists.
        :returns: An associative array containing the items.

    .. php:method:: save($items, $conflict = "fail")

        Update items on the cloud file system.

        :type $items: Item[]
        :param $items: The items to be updated.
        :type $conflict: string
        :param $conflict: The action to take if a conflict occurs.
        :returns: The success/fail response of the update operation.

    .. php:method:: upload($parent, $path, $name = null, $exists = "overwrite")

        Upload a file on to the given path.

        :type $parent: mixed
        :param $parent: The parent folder path.
        :type $path: string
        :param $path: The upload file path.
        :type $name: string
        :param $name: The name under which the file should be saved. If null local file name will be used.
        :type $exists: string
        :param $exists: The action to take if the item already exists.
        :returns: An instance of the uploaded item.

    .. php:method:: download($item, $file = null)

        Download an item from the cloud storage.

        :type $item: Item
        :param $item: The file to be downloaded.
        :type $file: mixed
        :param $file:
        :returns: The file content.

    .. php:method:: restore($items, $destination, $exists)

        Restore a given set of items to the supplied destination.

        :type $items: Item[]
        :param $items: The items to be restored.
        :type $destination: string
        :param $destination: The path the files are to be restored to
        :type $exists: string
        :param $exists: The action to take if the item already exists.
        :returns: The success/fail response of the restore operation.

    .. php:method:: fileHistory($item, $start = -10, $stop = 0)

        Retrieves the file history of a given item.

        :type $item: Item
        :param $item: The item for which the file history needs to be retrieved.
        :type $start: int
        :param $start: The start version.
        :type $stop: int
        :param $stop: The end version.
        :returns: File history entries.

    .. php:method:: shares()

    .. php:method:: createShare($path, $password = null)

        :param $path:
        :param $password:

    .. php:method:: browseShare($shareKey)

        :param $shareKey:

    .. php:method:: deleteShare($shareKey)

        :param $shareKey:

    .. php:method:: retrieveShare($shareKey, $path, $exists = Exists::RENAME)

        :param $shareKey:
        :param $path:
        :param $exists:

    .. php:method:: alterShare($shareKey, $values, $password = null)

        :param $shareKey:
        :param $values:
        :param $password:

    .. php:method:: unlockShare($shareKey, $password)

        :param $shareKey:
        :param $password:

    .. php:method:: fileVersions($file, $startVersion = 0, $endVersion = null, $limit = 10)

        Retrieves the file history of a given file.

        :type $file: File
        :param $file: The item for which the file history needs to be retrieved.
        :type $startVersion: int
        :param $startVersion: The start version.
        :type $endVersion: int
        :param $endVersion: The end version.
        :type $limit: int
        :param $limit: how many versions to list in the result set
        :returns: File history entries.
