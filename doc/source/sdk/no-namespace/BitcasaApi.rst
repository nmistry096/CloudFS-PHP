----------
BitcasaApi
----------

.. php:namespace:

.. php:class:: BitcasaApi

    .. php:method:: __construct($credential)

        Initializes the bitcasa api instance.

        :type $credential: Credential
        :param $credential:

    .. php:method:: getAccessToken($session, $username, $password)

        Retrieves the CloudFS access token through an api request.

        :type $session: Session
        :param $session: The bitcasa session.
        :type $username: string
        :param $username: Bitcasa username.
        :type $password: string
        :param $password: Bitcasa password.
        :returns: The success status of retrieving the access token.

    .. php:method:: getList($parent = null, $version = 0, $depth = 0, $filter = null)

        Retrieves the item list if a prent item is given, else returns the list
        of items under root.

        :type $parent: string
        :param $parent: The parent for which the items should be retrieved for.
        :type $version: int
        :param $version: Version filter for items being retrieved.
        :type $depth: int
        :param $depth: Depth variable for how many levels of items to be retrieved.
        :type $filter: mixed
        :param $filter: Variable to filter the items being retrieved.
        :returns: The item list.

    .. php:method:: getFileMeta($path)

        Retrieves the meta data of a file at a given path.

        :type $path: string
        :param $path: The path of the item.
        :returns: The meta data of the item.

    .. php:method:: getFolderMeta($path)

        Retrieves the meta data of a folder at a given path.

        :type $path: string
        :param $path: The path of the item.
        :returns: The meta data of the item.

    .. php:method:: createFolder($parentpath, $filename, $exists = Exists::FAIL)

        Create a folder at a given path with the supplied name.

        :type $parentpath: string
        :param $parentpath: The folder path under which the new folder should be created.
        :type $filename: string
        :param $filename: The name for the folder to be created.
        :type $exists: string
        :param $exists: Specifies the action to take if the folder already exists.
        :returns: An instance of the newly created item of type Folder.

    .. php:method:: deleteFolder($path, $force = false)

        Delete a folder from cloud storage.

        :type $path: string
        :param $path: The path of the folder to be deleted.
        :type $force: bool
        :param $force: The flag to force delete the folder from cloud storage.
        :returns: The success/fail response of the delete operation.

    .. php:method:: deleteFile($path, $force = false)

        Delete a file from cloud storage.

        :type $path: string
        :param $path: The path of the file to be deleted.
        :type $force: bool
        :param $force: The flag to force delete the file from cloud storage.
        :returns: The success/fail response of the delete operation.

    .. php:method:: alterFolder($path, $attrs, $conflict = "fail")

        Alter the attributes of the folder at a given path.

        :type $path: string
        :param $path: The folder path.
        :type $attrs: mixed
        :param $attrs: The attributes to be altered.
        :type $conflict: string
        :param $conflict: Specifies the action to take if a conflict occurs.
        :returns: The success/fail response of the alter operation.

    .. php:method:: alterFile($path, $attrs, $conflict = "fail")

        Alter the attributes of the file at a given path.

        :type $path: string
        :param $path: The file path.
        :type $attrs: mixed
        :param $attrs: The attributes to be altered.
        :type $conflict: string
        :param $conflict: Specifies the action to take if a conflict occurs.
        :returns: The success/fail response of the alter operation.

    .. php:method:: copyFolder($path, $dest, $name = null, $exists = "fail")

        Copy a folder at a given path to a specified destination.

        :type $path: string
        :param $path: The path of the folder to be copied.
        :type $dest: string
        :param $dest: Path to which the folder should be copied to.
        :type $name: string
        :param $name: Name of the newly copied folder.
        :type $exists: string
        :param $exists: Specifies the action to take if the folder already exists.
        :returns: The success/fail response of the copy operation

    .. php:method:: copyFile($path, $dest, $name = null, $exists = "fail")

        Copy a file at a given path to a specified destination.

        :type $path: string
        :param $path: The path of the file to be copied.
        :type $dest: string
        :param $dest: Path to which the file should be copied to.
        :type $name: string
        :param $name: Name of the newly copied file.
        :type $exists: string
        :param $exists: Specifies the action to take if the file already exists.
        :returns: The success/fail response of the copy operation

    .. php:method:: moveFolder($path, $dest, $name = null, $exists = "fail")

        Move a folder at a given path to a specified destination.

        :type $path: string
        :param $path: The path of the folder to be moved.
        :type $dest: string
        :param $dest: Path to which the folder should be moved to.
        :type $name: string
        :param $name: Name of the newly moved folder.
        :type $exists: string
        :param $exists: Specifies the action to take if the folder already exists.
        :returns: The success/fail response of the move operation

    .. php:method:: moveFile($path, $dest, $name = null, $exists = "fail")

        Move a file at a given path to a specified destination.

        :type $path: string
        :param $path: The path of the file to be moved.
        :type $dest: string
        :param $dest: Path to which the file should be moved to.
        :type $name: string
        :param $name: Name of the newly moved file.
        :type $exists: string
        :param $exists: Specifies the action to take if the file already exists.
        :returns: The success/fail response of the move operation

    .. php:method:: downloadFile($path, $file = null)

        Download a file from the cloud storage.

        :type $path: string
        :param $path: Path of the file to be downloaded.
        :type $file: mixed
        :param $file: The file container for which the item will be downloaded to
        :returns: The download file/link

    .. php:method:: uploadFile($parentpath, $name, $filepath, $exists = "overwrite")

        Upload a file on to the given path.

        :type $parentpath: string
        :param $parentpath: The parent folder path to which the file is to be uploaded.
        :type $name: string
        :param $name: The upload file name.
        :type $filepath: string
        :param $filepath: The file path for the file to be downloaded.
        :type $exists: string
        :param $exists: The action to take if the item already exists.
        :returns: An instance of the uploaded item.

    .. php:method:: restore($path, $dest)

        Restores the file at a given path to a given destination.

        :type $path: string
        :param $path: The path of the file to be restored.
        :type $dest: string
        :param $dest: The destination of the file to be restored to.
        :returns: The success/fail response of the restore operation.

    .. php:method:: fileHistory($path, $start = 0, $stop = 0, $limit = 0)

        Retrieves the file history of a given item.

        :type $path: string
        :param $path: The path of the item for which the file history needs to be retrieved.
        :type $start: int
        :param $start: Start version.
        :type $stop: int
        :param $stop: Stop version.
        :type $limit: int
        :param $limit: The limit of history entries.
        :returns: File history entries.
