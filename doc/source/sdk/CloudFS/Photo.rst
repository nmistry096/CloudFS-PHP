--------------
CloudFS\\Photo
--------------

.. php:namespace: CloudFS

.. php:class:: Photo

    .. php:attr:: data

        protected

    .. php:method:: __construct($api = null)

        Initializes a new instance of Photo.

        :type $api: BitcasaApi
        :param $api: The api instance.

    .. php:method:: download($localPath)

        Downloads this file from the cloud.

        :type $localPath: string
        :param $localPath: The local path where the file is to be downloaded to.

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

    .. php:method:: versions($startVersion = 0, $endVersion = null, $limit = 10)

        Returns the metadata for selected versions of a file as
        recorded in the History after successful metadata changes.

        :type $startVersion: int
        :param $startVersion:
        :type $endVersion: null
        :param $endVersion:
        :type $limit: int
        :param $limit:
        :returns: mixed

    .. php:method:: filesystem()

        Retrieves this api instance.

        :returns: The api instance.

    .. php:method:: change($key)

        Adds the passed change key to this items change list.

        :type $key: string
        :param $key: The supplied change key.

    .. php:method:: changes($add_version = false)

        Retrieves this items changes.

        :type $add_version: bool
        :param $add_version: Flag to add version to result or not.
        :returns: An array of this items changes.

    .. php:method:: componentsFromPath($pathString)

        Returns an array of path components given a path.

        :type $pathString: string
        :param $pathString: Path of an item.
        :returns: An array of path components.

    .. php:method:: pathFromItemList($items, $addRoot = False)

        Retrieves the path given an item list.

        :type $items: Item[]
        :param $items: The items whose path needs to be retrieved.
        :type $addRoot: bool
        :param $addRoot: Flag to add root to the retrieved path or not.
        :returns: Path of the item list.

    .. php:method:: pathFromComponents($components, $addRoot = False)

        Formats and returns the path of an item given an array of paths.

        :type $components: array
        :param $components: The array containing path elements.
        :type $addRoot: bool
        :param $addRoot: Flag to add root to the retrieved path or not.
        :returns: Formatted path for the given array.

    .. php:method:: pathFromItem($item = null)

        Retrieves the path for a given item.

        :type $item: Item
        :param $item: The item whose path needs to be retrieved.
        :returns: The path of the item.

    .. php:method:: make($data, $parentPath = null, $api = null)

        Retrieves an instance of an item for the supplied data.

        :type $data: object
        :param $data: The data needed to create an item.
        :type $parentPath: string
        :param $parentPath: Parent path for the new item.
        :type $api: Filesystem
        :param $api: The file system instance.
        :returns: An instance of the new item.

    .. php:method:: value($key, $default = null)

        Retrieves the data value of a given key.

        :type $key: string
        :param $key: The key for whose data value should be retrieved.
        :type $default: string
        :param $default: The value to be returned if the data value does not exist.
        :returns: The data value for the given key.

    .. php:method:: getName()

        Retrieves the name of this item.

        :returns: The name of the item.

    .. php:method:: setName($newName)

        Sets the name of this item.

        :type $newName: string
        :param $newName: The name of the item.

    .. php:method:: getId()

        Retrieves the id of this item.

        :returns: The data id of the item.

    .. php:method:: setId($newId)

        Sets the id of this item - Not Allowed.

        :type $newId: string
        :param $newId: The new id to be set on the item.

    .. php:method:: getParentId()

        Retrieves the parent id of this item.

        :returns: The parent id of this item.

    .. php:method:: getType()

        Retrieves the type of this item.

        :returns: The type of this item.

    .. php:method:: setType($newType)

        Set the type of this item - Not Allowed.

        :type $newType: string
        :param $newType: The new type to be set on the item.

    .. php:method:: getIsMirrored()

        Retrieves the is mirrored flag of this item.

        :returns: Is mirrored flag of this item.

    .. php:method:: setMirrored($newMirroredFlag)

        Sets the is mirrored flag of this item - Not Allowed.

        :type $newMirroredFlag: string
        :param $newMirroredFlag: The new mirrored flag to be set on the item.

    .. php:method:: getDateContentLastModified()

        Retrieve the content last modified date of this item.

        :returns: The content last modified date.

    .. php:method:: setDateContentLastModified($newDateContentLastModified)

        Sets the content last modified date of this item.

        :type $newDateContentLastModified: string
        :param $newDateContentLastModified: The new content last modified date.

    .. php:method:: getDateCreated()

        Retrieves the created date of this item.

        :returns: The created date of this item.

    .. php:method:: setDateCreated($newDateCreated)

        Sets the created date of this item.

        :type $newDateCreated: string
        :param $newDateCreated: The new created date.

    .. php:method:: version()

        Retrieves the version of this item.

        :returns: The version of this item.

    .. php:method:: setVersion($newVersion)

        Sets the version of this item.

        :type $newVersion: string
        :param $newVersion: The new version.

    .. php:method:: getParentPath()

        Retrieve the parent path id of this item.

        :returns: The parent path id of this item.

    .. php:method:: setParentPath($newAbsoluteParentPathId)

        Sets the parent path id of this item.

        :type $newAbsoluteParentPathId: string
        :param $newAbsoluteParentPathId: The new parent path id.

    .. php:method:: getDateMetaLastModified()

        Retrieves the meta last modified date of this item.

        :returns: The meta last modified date of this item.

    .. php:method:: setDateMetaLastModified($newDateMetaLastModified)

        Sets the meta last modified date of this item.

        :type $newDateMetaLastModified: string
        :param $newDateMetaLastModified: The new meta last modified date.

    .. php:method:: getApplicationData()

        Retrieves the application data of this item.

        :returns: The application data of this item.

    .. php:method:: setApplicationData($newApplicationData)

        Sets the new application data of this item.

        :type $newApplicationData: mixed
        :param $newApplicationData: The new application data.

    .. php:method:: url()

        Retrieves the url of this item.

        :returns: The full path of this item.

    .. php:method:: getPath()

        Retrieves the url of this item.

        :returns: The full path of this item.

    .. php:method:: move($destination, $exists = BitcasaConstants::EXISTS_RENAME)

        Moves this item to a given destination.

        :type $destination: string
        :param $destination: The destination of the item move.
        :type $exists: string
        :param $exists: The action to take if the item exists.
        :returns: The success/fail response of the move operation.

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
        :returns: The success/fail response of the delete operation.

    .. php:method:: save($ifConflict = "fail", $debug = False)

        Save this item on the cloud.

        :type $ifConflict: string
        :param $ifConflict: The action to take if a conflict occurs.
        :type $debug: bool
        :param $debug: Debug flag.
        :returns: The success/fail response of the save operation.

    .. php:method:: restore($destination)

        Restores this item to the given destination.

        :type $destination: string
        :param $destination: The destination of the item restore.
        :returns: The success/fail response of the restore operation.

    .. php:method:: history()

        Retrieves the files history of this file.

        :returns: The file history response.
