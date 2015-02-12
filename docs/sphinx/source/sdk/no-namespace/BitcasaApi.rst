----------
BitcasaApi
----------

.. php:namespace:

.. php:class:: BitcasaApi

    .. php:method:: __construct($credential)

        Initializes the bitcasa api instance.

        :param $credential:

    .. php:method:: getAccessToken($session, $username, $password)

        Retrieves the CloudFS access token through an api request.

        :param $session:
        :param $username:
        :param $password:
        :returns: bool

    .. php:method:: getList($parent = null, $version = 0, $depth = 0, $filter = null)

        Retrieves the item list if a prent item is given, else returns the list
        of items under root.

        :type $parent: null
        :param $parent: The parent for which the items should be retrieved for.
        :type $version: int
        :param $version: Version filter for items being retrieved.
        :type $depth: int
        :param $depth: Depth variable for how many levels of items to be retrieved.
        :type $filter: null
        :param $filter: Variable to filter the items being retrieved.
        :returns: The item list.

    .. php:method:: getFileMeta($path)

        Retrieves the meta data of a file at a given path.

        :param $path:
        :returns: The meta data of the item.

    .. php:method:: getFolderMeta($path)

        Retrieves the meta data of a folder at a given path.

        :param $path:
        :returns: The meta data of the item.

    .. php:method:: createFolder($parentpath, $filename, $exists = Exists::FAIL)

        Create a folder at a given path with the supplied name.

        :param $parentpath:
        :param $filename:
        :type $exists: string
        :param $exists: Specifies the action to take if the folder already exists.
        :returns: An instance of the newly created item of type Folder.

    .. php:method:: deleteFolder($path, $force = false)

        Delete a folder from cloud storage.

        :param $path:
        :type $force: bool
        :param $force: The flag to force delete the folder from cloud storage.
        :returns: The success/fail response of the delete operation.

    .. php:method:: deleteFile($path, $force = false)

        Delete a file from cloud storage.

        :param $path:
        :type $force: bool
        :param $force: The flag to force delete the file from cloud storage.
        :returns: The success/fail response of the delete operation.

    .. php:method:: alterFolder($path, $attrs, $conflict = "fail")

        Alter the attributes of the folder at a given path.

        :param $path:
        :param $attrs:
        :type $conflict: string
        :param $conflict: Specifies the action to take if a conflict occurs.
        :returns: The success/fail response of the alter operation.

    .. php:method:: alterFile($path, $attrs, $conflict = "fail")

        Alter the attributes of the file at a given path.

        :param $path:
        :param $attrs:
        :type $conflict: string
        :param $conflict: Specifies the action to take if a conflict occurs.
        :returns: The success/fail response of the alter operation.

    .. php:method:: copyFolder($path, $dest, $name = null, $exists = "fail")

        Copy a folder at a given path to a specified destination.

        :param $path:
        :param $dest:
        :param $name:
        :type $exists: string
        :param $exists: Specifies the action to take if the folder already exists.
        :returns: The success/fail response of the copy operation

    .. php:method:: copyFile($path, $dest, $name = null, $exists = "fail")

        Copy a file at a given path to a specified destination.

        :param $path:
        :param $dest:
        :param $name:
        :type $exists: string
        :param $exists: Specifies the action to take if the file already exists.
        :returns: The success/fail response of the copy operation

    .. php:method:: moveFolder($path, $dest, $name = null, $exists = "fail")

        Move a folder at a given path to a specified destination.

        :param $path:
        :param $dest:
        :param $name:
        :type $exists: string
        :param $exists: Specifies the action to take if the folder already exists.
        :returns: The success/fail response of the move operation

    .. php:method:: moveFile($path, $dest, $name = null, $exists = "fail")

        Move a file at a given path to a specified destination.

        :param $path:
        :param $dest:
        :param $name:
        :type $exists: string
        :param $exists: Specifies the action to take if the file already exists.
        :returns: The success/fail response of the move operation

    .. php:method:: downloadFile($path, $file = null)

        Download a file from the cloud storage.

        :param $path:
        :type $file: null
        :param $file: The file container for which the item will be downloaded to
        :returns: The download file/link

    .. php:method:: uploadFile($parentpath, $name, $filepath, $exists = "overwrite")

        Upload a file on to the given path.

        :param $parentpath:
        :param $name:
        :param $filepath:
        :type $exists: string
        :param $exists: The action to take if the item already exists.
        :returns: An instance of the uploaded item.

    .. php:method:: restore($path, $dest)

        Restores the file at a given path to a given destination.

        :param $path:
        :param $dest:
        :returns: The success/fail response of the restore operation.

    .. php:method:: fileHistory($path, $start = 0, $stop = 0, $limit = 0)

        Retrieves the file history of a given item.

        :param $path:
        :type $start: int
        :param $start: Start version.
        :type $stop: int
        :param $stop: Stop version.
        :type $limit: int
        :param $limit: The limit of history entries.
        :returns: File history entries.
