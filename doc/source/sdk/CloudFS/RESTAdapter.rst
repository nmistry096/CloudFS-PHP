--------------------
CloudFS\\RESTAdapter
--------------------

.. php:namespace: CloudFS

.. php:class:: RESTAdapter

    .. php:method:: __construct($credential)

        Initializes the bitcasa api instance.

        :type $credential: Credential
        :param $credential:

    .. php:method:: authenticate($session, $username, $password)

        Authenticates with bitcasa and gets the access token.

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

    .. php:method:: getItemMeta($path)

        Retrieves the meta data of a item at a given path.

        :type $path: string
        :param $path: The path of the item.
        :returns: The json string containing the meta data of the item.

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

    .. php:method:: createFolder($parentPath, $name, $exists = Exists::FAIL)

        Create a folder at a given path with the supplied name.

        :type $parentPath: string
        :param $parentPath: The folder path under which the new folder should be created.
        :type $name: string
        :param $name: The name for the folder to be created.
        :type $exists: string
        :param $exists: Specifies the action to take if the folder already exists.
        :returns: An instance of the newly created item of type Folder.

    .. php:method:: deleteFolder($path, $commit = false, $force = false)

        Delete a folder from cloud storage.

        :type $path: string
        :param $path: The path of the folder to be deleted.
        :type $commit: bool
        :param $commit: Either move the folder to the Trash (false) or delete it immediately (true)
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

    .. php:method:: alterFolderMeta($path, $values, $conflict = Conflict::FAIL)

        Alter the attributes of the folder at a given path.

        :type $path: string
        :param $path: The folder path.
        :type $values: mixed
        :param $values: The attributes to be altered.
        :type $conflict: string
        :param $conflict: Specifies the action to take if a conflict occurs.
        :returns: The success/fail response of the alter operation.

    .. php:method:: alterFileMeta($path, $values, $conflict = Conflict::FAIL)

        Alter the attributes of the file at a given path.

        :type $path: string
        :param $path: The file path.
        :type $values: mixed
        :param $values: The attributes to be altered.
        :type $conflict: string
        :param $conflict: Specifies the action to take if a conflict occurs.
        :returns: The success/fail response of the alter operation.

    .. php:method:: copyFolder($path, $destination, $name = null, $exists = Exists::FAIL)

        Copy a folder at a given path to a specified destination.

        :type $path: string
        :param $path: The path of the folder to be copied.
        :type $destination: string
        :param $destination: Path to which the folder should be copied to.
        :type $name: string
        :param $name: Name of the newly copied folder.
        :type $exists: string
        :param $exists: Specifies the action to take if the folder already exists.
        :returns: The copied folder instance.

    .. php:method:: copyFile($path, $destination, $name = null, $exists = Exists::FAIL)

        Copy a file at a given path to a specified destination.

        :type $path: string
        :param $path: The path of the file to be copied.
        :type $destination: string
        :param $destination: Path to which the file should be copied to.
        :type $name: string
        :param $name: Name of the newly copied file.
        :type $exists: string
        :param $exists: Specifies the action to take if the file already exists.
        :returns: The copied file instance.

    .. php:method:: moveFolder($path, $destination, $name = null, $exists = Exists::FAIL)

        Move a folder at a given path to a specified destination.

        :type $path: string
        :param $path: The path of the folder to be moved.
        :type $destination: string
        :param $destination: Path to which the folder should be moved to.
        :type $name: string
        :param $name: Name of the newly moved folder.
        :type $exists: string
        :param $exists: Specifies the action to take if the folder already exists.
        :returns: The json response containing moved folder data.

    .. php:method:: moveFile($path, $destination, $name = null, $exists = Exists::FAIL)

        Move a file at a given path to a specified destination.

        :type $path: string
        :param $path: The path of the file to be moved.
        :type $destination: string
        :param $destination: Path to which the file should be moved to.
        :type $name: string
        :param $name: Name of the newly moved file.
        :type $exists: string
        :param $exists: Specifies the action to take if the file already exists.
        :returns: The json response containing moved file data.

    .. php:method:: downloadFile($path, $localDestinationPath, $downloadProgressCallback)

        Download a file from the cloud storage.

        :type $path: string
        :param $path: Path of the file to be downloaded.
        :type $localDestinationPath: string
        :param $localDestinationPath: The local path of the file to download the content.
        :type $downloadProgressCallback: mixed
        :param $downloadProgressCallback: The download progress callback function. This function should take 'downloadSize', 'downloadedSize', 'uploadSize', 'uploadedSize' as arguments.
        :returns: The download status.

    .. php:method:: uploadFile($parentPath, $name, $filePath, $exists = Exists::OVERWRITE, $uploadProgressCallback = null)

        Upload a file on to the given path.

        :type $parentPath: string
        :param $parentPath: The parent folder path to which the file is to be uploaded.
        :type $name: string
        :param $name: The upload file name.
        :type $filePath: string
        :param $filePath: The file path for the file to be downloaded.
        :type $exists: string
        :param $exists: The action to take if the item already exists.
        :type $uploadProgressCallback: mixed
        :param $uploadProgressCallback: The upload progress callback function. This function should take 'downloadSize', 'downloadedSize', 'uploadSize', 'uploadedSize' as arguments.
        :returns: An instance of the uploaded item.

    .. php:method:: restore($path, $destination, $restoreMethod = RestoreMethod::FAIL, $restoreArgument = null)

        Restores the file at a given path to a given destination.

        :type $path: string
        :param $path: The item path.
        :type $destination: string
        :param $destination: The destination path.
        :type $restoreMethod: string
        :param $restoreMethod: The restore method.
        :type $restoreArgument: string
        :param $restoreArgument: The restore argument.
        :returns: The state of the restore operation.

    .. php:method:: createShare($path, $password = null)

        Create a share of an item at the supplied path.

        :type $path: string|array
        :param $path: The paths of the item to be shared.
        :type $password: string
        :param $password: The password of the shared to be created.
        :returns: An instance of the share.

    .. php:method:: shares()

        Retrieves the list of shares on the filesystem.

        :returns: The share list in user file system.

    .. php:method:: browseShare($shareKey, $path = null)

        Retrieves the items for a supplied share key.

        :type $shareKey: string
        :param $shareKey: The supplied share key.
        :type $path: string
        :param $path: The path to any folder inside the share.
        :returns: The json response containing the items for the share.

    .. php:method:: receiveShare($shareKey, $path, $exists = Exists::OVERWRITE)

        Receives the share item for a given share key to a path supplied.

        :type $shareKey: string
        :param $shareKey: The supplied share key.
        :type $path: string
        :param $path: The path to which the share files are retrieved to.
        :type $exists: string
        :param $exists: The action to take if the item already exists.
        :returns: The success/failure status of the retrieve operation.

    .. php:method:: deleteShare($shareKey)

        Deletes the share item for a supplied share key.

        :type $shareKey: string
        :param $shareKey: The supplied share key.
        :returns: The success/failure status of the delete operation.

    .. php:method:: unlockShare($shareKey, $password)

        Unlocks the share item of the supplied share key for the duration of the
        session.

        :type $shareKey: string
        :param $shareKey: The supplied share key.
        :type $password: string
        :param $password: The share password.
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

    .. php:method:: fileVersions($path, $startVersion, $endVersion, $limit)

        :type $path: string
        :param $path: The item path.
        :type $startVersion: int
        :param $startVersion: The start version number.
        :type $endVersion: int
        :param $endVersion: The end version number.
        :type $limit: int
        :param $limit: The number of versions to retrieve.
        :returns: The json response containing the version history.

    .. php:method:: fileRead($path)

        Streams the content of a given file at the supplied path

        :type $path: string
        :param $path: The file path.
        :returns: The file stream.

    .. php:method:: listTrash($path = null)

        Browses the Trash meta folder on the authenticated user’s account.

        :param $path:
        :returns: The error status or the returned items in trash.

    .. php:method:: deleteTrashItem($path)

        :param $path:
        :returns: The json response containing the status of the delete operation.

    .. php:method:: downloadUrl($path)

        Gets the download url for the specified file.

        :type $path: string
        :param $path: The file path.
        :returns: The download url for the specified file.
