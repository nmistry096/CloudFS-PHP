----------
BitcasaApi
----------

.. php:namespace:

.. php:class:: BitcasaApi

    .. php:method:: __construct($credential)

        :param $credential:

    .. php:method:: getAccessToken($session, $username, $password)

        an api request to CloudFS server to get access token

        :param $session:
        :param $username:
        :param $password:

    .. php:method:: getList($parent = null, $version = 0, $depth = 0, $filter = null)

        :param $parent:
        :param $version:
        :param $depth:
        :param $filter:

    .. php:method:: getFileMeta($path)

        :param $path:

    .. php:method:: getFolderMeta($path)

        :param $path:

    .. php:method:: createFolder($parentpath, $filename, $exists = Exists::FAIL)

        :param $parentpath:
        :param $filename:
        :param $exists:

    .. php:method:: deleteFolder($path, $force = false)

        :param $path:
        :param $force:

    .. php:method:: deleteFile($path, $force = false)

        :param $path:
        :param $force:

    .. php:method:: alterFolder($path, $attrs, $conflict = "fail")

        :param $path:
        :param $attrs:
        :param $conflict:

    .. php:method:: alterFile($path, $attrs, $conflict = "fail")

        :param $path:
        :param $attrs:
        :param $conflict:

    .. php:method:: copyFolder($path, $dest, $name = null, $exists = "fail")

        :param $path:
        :param $dest:
        :param $name:
        :param $exists:

    .. php:method:: copyFile($path, $dest, $name = null, $exists = "fail")

        :param $path:
        :param $dest:
        :param $name:
        :param $exists:

    .. php:method:: moveFolder($path, $dest, $name = null, $exists = "fail")

        :param $path:
        :param $dest:
        :param $name:
        :param $exists:

    .. php:method:: moveFile($path, $dest, $name = null, $exists = "fail")

        :param $path:
        :param $dest:
        :param $name:
        :param $exists:

    .. php:method:: downloadFile($path, $file = null)

        :param $path:
        :param $file:

    .. php:method:: uploadFile($parentpath, $name, $filepath, $exists = "overwrite")

        :param $parentpath:
        :param $name:
        :param $filepath:
        :param $exists:

    .. php:method:: restore($path, $dest)

        :param $path:
        :param $dest:

    .. php:method:: fileHistory($path, $start = 0, $stop = 0, $limit = 0)

        :param $path:
        :param $start:
        :param $stop:
        :param $limit:
