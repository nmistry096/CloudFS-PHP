-----
Video
-----

.. php:namespace:

.. php:class:: Video

    .. php:method:: __construct($api = null)

        :param $api:

    .. php:method:: download($localPath)

        :param $localPath:

    .. php:method:: change($key)

        :param $key:

    .. php:method:: changes($add_version = false)

        :param $add_version:

    .. php:method:: components_from_path($path_string)

        :param $path_string:

    .. php:method:: path_from_item_list($items, $add_root = False)

        :param $items:
        :param $add_root:

    .. php:method:: path_from_components($components, $add_root = False)

        :param $components:
        :param $add_root:

    .. php:method:: path_from_item($item = null)

        :param $item:

    .. php:method:: make($data, $parent = null, $api = null)

        :param $data:
        :param $parent:
        :param $api:

    .. php:method:: value($key, $default = null)

        :param $key:
        :param $default:

    .. php:method:: name()

    .. php:method:: set_name($new_name)

        :param $new_name:

    .. php:method:: id()

    .. php:method:: set_id($new_id)

        :param $new_id:

    .. php:method:: type()

    .. php:method:: set_type($new_type)

        :param $new_type:

    .. php:method:: is_mirrored()

    .. php:method:: set_mirrored($new_mirrored_flag)

        :param $new_mirrored_flag:

    .. php:method:: date_content_last_modified()

    .. php:method:: set_date_content_last_modified($new_date_content_last_modified)

        :param $new_date_content_last_modified:

    .. php:method:: date_created()

    .. php:method:: set_date_created($new_date_created)

        :param $new_date_created:

    .. php:method:: version()

    .. php:method:: set_version($new_version)

        :param $new_version:

    .. php:method:: parent_path()

    .. php:method:: set_parent_path($new_absolute_parent_path_id)

        :param $new_absolute_parent_path_id:

    .. php:method:: date_meta_last_modified()

    .. php:method:: set_date_meta_last_modified($new_date_meta_last_modified)

        :param $new_date_meta_last_modified:

    .. php:method:: application_data()

    .. php:method:: set_application_data($new_application_data)

        :param $new_application_data:

    .. php:method:: url()

    .. php:method:: path()

    .. php:method:: move_to($dest)

        :param $dest:

    .. php:method:: copy_to($dest)

        :param $dest:

    .. php:method:: delete($commit = False, $force = False)

        :param $commit:
        :param $force:

    .. php:method:: save($if_conflict = "fail", $debug = False)

        :param $if_conflict:
        :param $debug:

    .. php:method:: restore($dest)

        :param $dest:

    .. php:method:: history()
