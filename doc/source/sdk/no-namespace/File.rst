----
File
----

.. php:namespace:

.. php:class:: File

    .. php:method:: __construct($api = null)

        Initializes a new instance of File.

        :type $api: BitcasaApi
        :param $api: The api instance.

    .. php:method:: download($localPath)

        Downloads this file from the cloud.

        :type $localPath: string
        :param $localPath: The local path where the file is to be downloaded to.

    .. php:method:: api()

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

    .. php:method:: components_from_path($path_string)

        Returns an array of path components given a path.

        :type $path_string: string
        :param $path_string: Path of an item.
        :returns: An array of path components.

    .. php:method:: path_from_item_list($items, $add_root = False)

        Retrieves the path given an item list.

        :type $items: Item[]
        :param $items: The items whose path needs to be retrieved.
        :type $add_root: bool
        :param $add_root: Flag to add root to the retrieved path or not.
        :returns: Path of the item list.

    .. php:method:: path_from_components($components, $add_root = False)

        Formats and returns the path of an item given an array of paths.

        :type $components: array
        :param $components: The array containing path elements.
        :type $add_root: bool
        :param $add_root: Flag to add root to the retrieved path or not.
        :returns: Formatted path for the given array.

    .. php:method:: path_from_item($item = null)

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
        :type $api: BitcasaApi
        :param $api: The api instance.
        :returns: An instance of the new item.

    .. php:method:: value($key, $default = null)

        Retrieves the data value of a given key.

        :type $key: string
        :param $key: The key for whose data value should be retrieved.
        :type $default: string
        :param $default: The value to be returned if the data value does not exist.
        :returns: The data value for the given key.

    .. php:method:: name()

        Retrieves the name of this item.

        :returns: The name of the item.

    .. php:method:: set_name($new_name)

        Sets the name of this item.

        :type $new_name: string
        :param $new_name: The name of the item.

    .. php:method:: id()

        Retrieves the id of this item.

        :returns: The data id of the item.

    .. php:method:: set_id($new_id)

        Sets the id of this item - Not Allowed.

        :type $new_id: string
        :param $new_id: The new id to be set on the item.

    .. php:method:: parent_id()

        Retrieves the parent id of this item.

        :returns: The parent id of this item.

    .. php:method:: type()

        Retrieves the type of this item.

        :returns: The type of this item.

    .. php:method:: set_type($new_type)

        Set the type of this item - Not Allowed.

        :type $new_type: string
        :param $new_type: The new type to be set on the item.

    .. php:method:: is_mirrored()

        Retrieves the is mirrored flag of this item.

        :returns: Is mirrored flag of this item.

    .. php:method:: set_mirrored($new_mirrored_flag)

        Sets the is mirrored flag of this item - Not Allowed.

        :type $new_mirrored_flag: string
        :param $new_mirrored_flag: The new mirrored flag to be set on the item.

    .. php:method:: date_content_last_modified()

        Retrieve the content last modified date of this item.

        :returns: The content last modified date.

    .. php:method:: set_date_content_last_modified($new_date_content_last_modified)

        Sets the content last modified date of this item.

        :type $new_date_content_last_modified: string
        :param $new_date_content_last_modified: The new content last modified date.

    .. php:method:: date_created()

        Retrieves the created date of this item.

        :returns: The created date of this item.

    .. php:method:: set_date_created($new_date_created)

        Sets the created date of this item.

        :type $new_date_created: string
        :param $new_date_created: The new created date.

    .. php:method:: version()

        Retrieves the version of this item.

        :returns: The version of this item.

    .. php:method:: set_version($new_version)

        Sets the version of this item.

        :type $new_version: string
        :param $new_version: The new version.

    .. php:method:: parent_path()

        Retrieve the parent path id of this item.

        :returns: The parent path id of this item.

    .. php:method:: set_parent_path($new_absolute_parent_path_id)

        Sets the parent path id of this item.

        :type $new_absolute_parent_path_id: string
        :param $new_absolute_parent_path_id: The new parent path id.

    .. php:method:: date_meta_last_modified()

        Retrieves the meta last modified date of this item.

        :returns: The meta last modified date of this item.

    .. php:method:: set_date_meta_last_modified($new_date_meta_last_modified)

        Sets the meta last modified date of this item.

        :type $new_date_meta_last_modified: string
        :param $new_date_meta_last_modified: The new meta last modified date.

    .. php:method:: application_data()

        Retrieves the application data of this item.

        :returns: The application data of this item.

    .. php:method:: set_application_data($new_application_data)

        Sets the new application data of this item.

        :type $new_application_data: mixed
        :param $new_application_data: The new application data.

    .. php:method:: url()

        Retrieves the url of this item.

        :returns: The full path of this item.

    .. php:method:: path()

        Retrieves the url of this item.

        :returns: The full path of this item.

    .. php:method:: move_to($dest, $exists = "fail")

        Moves this item to a given destination.

        :type $dest: string
        :param $dest: The destination of the item move.
        :type $exists: string
        :param $exists: The action to take if the item exists.
        :returns: The success/fail response of the move operation.

    .. php:method:: copy_to($dest, $exists = "fail")

        Copy this item to a given destination.

        :type $dest: string
        :param $dest: The destination of the item copy.
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

    .. php:method:: save($if_conflict = "fail", $debug = False)

        Save this item on the cloud.

        :type $if_conflict: string
        :param $if_conflict: The action to take if a conflict occurs.
        :type $debug: bool
        :param $debug: Debug flag.
        :returns: The success/fail response of the save operation.

    .. php:method:: restore($dest)

        Restores this item to the given destination.

        :type $dest: string
        :param $dest: The destination of the item restore.
        :returns: The success/fail response of the restore operation.

    .. php:method:: history()

        Retrieves the files history of this file.

        :returns: The file history response.
