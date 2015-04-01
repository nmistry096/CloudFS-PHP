--------------
CloudFS\\Photo
--------------

.. php:namespace: CloudFS

.. php:class:: Photo

    .. php:method:: __construct($data, $parentPath, $restAdapter, $parentState)

        Initializes a new instance of Photo.

        :type $data: array
        :param $data: The item data.
        :type $parentPath: string
        :param $parentPath: The item parent path.
        :type $restAdapter: \CloudFS\RESTAdapter
        :param $restAdapter: The rest adapter instance.
        :type $parentState: array
        :param $parentState: The parent state.

    .. php:method:: getExtension()

        Retrieves the extension of this item.

        :returns: The extension of this item.

    .. php:method:: getMime()

        Retrieves the mime type of this item.

        :returns: The mime type of this item.

    .. php:method:: setMime($newMime)

        Sets the Mime type of this item.

        :type $newMime: string
        :param $newMime: The new Mime type of the item.

    .. php:method:: getSize()

        Retrieves the size of this item.

        :returns: The size of this item.

    .. php:method:: download($localDestinationPath, $downloadProgressCallback)

        Downloads the file from the cloud.

        :type $localDestinationPath: string
        :param $localDestinationPath: The local path of the file to download the content.
        :type $downloadProgressCallback: mixed
        :param $downloadProgressCallback: The download progress callback function. This function should take 'downloadSize', 'downloadedSize', 'uploadSize', 'uploadedSize' as arguments.
        :returns: The download status.

    .. php:method:: versions($startVersion = 0, $endVersion = null, $limit = 10)

        Returns the metadata for selected versions of a file as
        recorded in the History after successful metadata changes.

        :type $startVersion: int
        :param $startVersion: The version from which the version retrieval should start.
        :type $endVersion: int
        :param $endVersion: Up to which version the version retrieval should be done.
        :type $limit: int
        :param $limit: The number of versions to be retrieved limit.
        :returns: The versions list.

    .. php:method:: read()

        Read the file stream.

        :returns: The file stream.

    .. php:method:: downloadUrl()

        Gets the download url for the file.

        :returns: The download url.

    .. php:method:: getName()

        Retrieves the item name.

        :returns: The item name.

    .. php:method:: setName($newName)

        Sets the item name.

        :type $newName: string
        :param $newName: The item name.

    .. php:method:: getId()

        Gets the item id.

        :returns: The data id of the item.

    .. php:method:: getType()

        Retrieves the type of this item.

        :returns: The type of this item.

    .. php:method:: getDateContentLastModified()

        Retrieve the content last modified date of this item.

        :returns: The content last modified date.

    .. php:method:: getDateCreated()

        Retrieves the created date of this item.

        :returns: The created date of this item.

    .. php:method:: getDateMetaLastModified()

        Retrieves the meta last modified date of this item.

        :returns: The meta last modified date of this item.

    .. php:method:: getApplicationData()

        Retrieves the application data of this item.

        :returns: The application data of this item.

    .. php:method:: setApplicationData($newApplicationData)

        Sets the item application data.

        :type $newApplicationData: array
        :param $newApplicationData: The application data.

    .. php:method:: getPath()

        Retrieves the url of this item.

        :returns: The full path of this item.

    .. php:method:: getIsMirrored()

        Retrieves the is mirrored flag of this item.

        :returns: Is mirrored flag of this item.

    .. php:method:: getParentState()

        Gets the parent state of the item.

        :returns: The parent state.

    .. php:method:: getVersion()

        Gets the item version number.

        :returns: The item version number.

    .. php:method:: restAdapter()

        Retrieves this rest adapter instance.

        :returns: \CloudFS\RESTAdapter The rest adapter instance.

    .. php:method:: make($data, $parentPath = null, $restAdapter = null, $parentState = null)

        Retrieves an instance of an item for the supplied data.

        :type $data: array
        :param $data: The data needed to create an item.
        :type $parentPath: string
        :param $parentPath: Parent path for the new item.
        :type $restAdapter: \CloudFS\RESTAdapter
        :param $restAdapter: The rest adapter instance.
        :type $parentState: array
        :param $parentState: The parent state.
        :returns: An instance of the new item.

    .. php:method:: changeAttributes($values, $ifConflict = VersionExists::FAIL)

        Alters the specified attributes.

        :type $values: array
        :param $values: The values that need to be changed.
        :type $ifConflict: int
        :param $ifConflict: Defines what to do when a conflict occurs.
        :returns: The status of the operation.

    .. php:method:: move($destination, $exists = BitcasaConstants::EXISTS_RENAME)

        Moves this item to a given destination.

        :type $destination: string
        :param $destination: The destination of the item move.
        :type $exists: string
        :param $exists: The action to take if the item exists.
        :returns: The moved item instance.

    .. php:method:: copy($destination, $exists = BitcasaConstants::EXISTS_RENAME)

        Copy this item to a given destination.

        :type $destination: string
        :param $destination: The destination of the item copy.
        :type $exists: string
        :param $exists: The action to take if the item exists.
        :returns: The success/fail response of the copy operation.

    .. php:method:: delete($commit = False, $force = False)

        Delete this item from the cloud.

        :type $commit: bool
        :param $commit: Flag to commit the delete operation.
        :type $force: bool
        :param $force: Flag to force the delete operation.
        :returns: Boolean value indicating the status of the delete operation.

    .. php:method:: restore($destination, $restoreMethod = RestoreMethod::FAIL, $restoreArgument = null)

        Restores this item to the given destination.

        :type $destination: string
        :param $destination: The destination of the item restore.
        :type $restoreMethod: string
        :param $restoreMethod: The restore method.
        :type $restoreArgument: string
        :param $restoreArgument: The restore argument.
        :returns: The success/fail response of the restore operation.

    .. php:method:: history()

        Retrieves the files history of this file.

        :returns: The file history response.
