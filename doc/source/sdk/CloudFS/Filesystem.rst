-------------------
CloudFS\\Filesystem
-------------------

.. php:namespace: CloudFS

.. php:class:: Filesystem

    Defines the Bitcasa file system.

    .. php:method:: __construct($restAdapter)

        Initialize the Filesystem instance.

        :type $restAdapter: object
        :param $restAdapter: The restAdapter instance.

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

    .. php:method:: deleteTrash($items)

        :param $items:

    .. php:method:: create($parent, $name, $exists = Exists::OVERWRITE)

        Create a folder with supplied name under the given parent folders,
        folder path.

        :type $parent: Item
        :param $parent: Folder item under which the new folder should be created.
        :type $name: string
        :param $name: The name of the folder to be created.
        :type $exists: string
        :param $exists: Specifies the action to take if the folder already exists.
        :returns: A folder instance.

    .. php:method:: move($items, $destination, $exists = Exists::FAIL)

        Moves multiple items to a specified destination.

        :type $items: Item[]
        :param $items: The items to be moved.
        :type $destination: string
        :param $destination: path to which the items should be moved to.
        :type $exists: string
        :param $exists: Specifies the action to take if the item already exists.
        :returns: An associative array containing the items.

    .. php:method:: copy($items, $destination, $exists = Exists::FAIL)

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

    .. php:method:: alterFolder($path, $values, $ifConflict = VersionExists::FAIL)

        :param $path:
        :param $values:
        :param $ifConflict:

    .. php:method:: alterFile($path, $values, $ifConflict = VersionExists::FAIL)

        :param $path:
        :param $values:
        :param $ifConflict:

    .. php:method:: upload($parent, $path, $name = null, $exists = Exists::OVERWRITE, $uploadProgressCallback = null)

        Upload a file on to the given path.

        :type $parent: mixed
        :param $parent: The parent folder path.
        :type $path: string
        :param $path: The upload file path.
        :type $name: string
        :param $name: The name under which the file should be saved. If null local file name will be used.
        :type $exists: string
        :param $exists: The action to take if the item already exists.
        :type $uploadProgressCallback: mixed
        :param $uploadProgressCallback: The upload progress callback function. This function should take 'downloadSize', 'downloadedSize', 'uploadSize', 'uploadedSize' as arguments.
        :returns: An instance of the uploaded item.

    .. php:method:: download($path, $localDestinationPath, $downloadProgressCallback)

        Download an item from the cloud storage.

        :type $path: string
        :param $path: The item path.
        :type $localDestinationPath: string
        :param $localDestinationPath: The local path of the file to download the content.
        :type $downloadProgressCallback: mixed
        :param $downloadProgressCallback: The download progress callback function. This function should take 'downloadSize', 'downloadedSize', 'uploadSize', 'uploadedSize' as arguments.
        :returns: The download status.

    .. php:method:: restore($pathId, $destination, $restoreMethod = RestoreMethod::FAIL, $restoreArgument = null)

        Restore a given set of items to the supplied destination.

        :type $pathId: string
        :param $pathId: The item id.
        :type $destination: string
        :param $destination: The path the files are to be restored to
        :type $restoreMethod: string
        :param $restoreMethod: The action to take if the item already exists.
        :type $restoreArgument: string
        :param $restoreArgument: The restore extra argument
        :returns: The True/False response of the restore operation.

    .. php:method:: fileHistory($item, $start = -10, $stop = 0)

        Retrieves the file history of a given item.

        :type $item: Item
        :param $item: The item for which the file history needs to be retrieved.
        :type $start: int
        :param $start: The start version.
        :type $stop: int
        :param $stop: The end version.
        :returns: File history entries.

    .. php:method:: listShares()

        Retrieves the list of shares on the filesystem.

        :returns: The share list.

    .. php:method:: retrieveShare($shareKey, $password = null)

        Retrieves the shared item for the specified key.

        :type $shareKey: string
        :param $shareKey: The share key.
        :type $password: string
        :param $password: The password for the share.
        :returns: An instance of share.

    .. php:method:: createShare($path, $password = null)

        Create a share of an item at the supplied path.

        :type $path: string
        :param $path: The path of the item to be shared.
        :type $password: string
        :param $password: The password of the shared to be created.
        :returns: An instance of the share.

    .. php:method:: browseShare($shareKey)

        Retrieves the items for a supplied share key.

        :type $shareKey: string
        :param $shareKey: The supplied share key.
        :returns: An array of items for the share key.

    .. php:method:: deleteShare($shareKey)

        Deletes the share item for a supplied share key.

        :type $shareKey: string
        :param $shareKey: The supplied share key.
        :returns: The success/failure status of the delete operation.

    .. php:method:: receiveShare($shareKey, $path, $exists = Exists::RENAME)

        Receive the share item for a given share key to a path supplied.

        :type $shareKey: string
        :param $shareKey: The supplied share key.
        :type $path: string
        :param $path: The path to which the share files are retrieved to.
        :type $exists: string
        :param $exists: The action to take if the item already exists.
        :returns: The success/failure status of the retrieve operation.

    .. php:method:: alterShare($shareKey, $values, $password = null)

        Alter the properties of a share item for a given share key with the
        supplied data.

        :type $shareKey: string
        :param $shareKey: The supplied share key.
        :type $values: mixed[]
        :param $values: The values to be changed.
        :type $password: string
        :param $password: The share password.
        :returns: An instance of the altered share.

    .. php:method:: unlockShare($shareKey, $password)

        Unlocks the share item of the supplied share key for the duration of the
        session.

        :type $shareKey: string
        :param $shareKey: The supplied share key.
        :type $password: string
        :param $password: The share password.
        :returns: The success/failure status of the retrieve operation.

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

    .. php:method:: fileRead($file)

        Streams the content of a given file

        :type $file: File
        :param $file: The file to be streamed.
        :returns: The file stream.

    .. php:method:: listTrash()

        Browses the Trash metafolder on the authenticated user’s account.
