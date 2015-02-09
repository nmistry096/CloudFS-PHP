----------
Filesystem
----------

.. php:namespace:

.. php:class:: Filesystem

    .. php:method:: __construct($api)

        :param $api:

    .. php:method:: getList($dir = null)

        :param $dir:

    .. php:method:: getFile($path)

        :param $path:

    .. php:method:: getFolder($path)

        :param $path:

    .. php:method:: delete($items, $force = false)

        :param $items:
        :param $force:

    .. php:method:: create($parent, $name, $exists = "overwrite")

        :param $parent:
        :param $name:
        :param $exists:

    .. php:method:: move($items, $destination, $exists = "fail")

        :param $items:
        :param $destination:
        :param $exists:

    .. php:method:: copy($items, $destination, $exists = "fail")

        :param $items:
        :param $destination:
        :param $exists:

    .. php:method:: save($items, $conflict = "fail")

        :param $items:
        :param $conflict:

    .. php:method:: upload($parent, $path, $exists = "overwrite")

        :param $parent:
        :param $path:
        :param $exists:

    .. php:method:: download($item, $file = null)

        :param $item:
        :param $file:

    .. php:method:: restore($items, $destination, $exists)

        :param $items:
        :param $destination:
        :param $exists:

    .. php:method:: fileHistory($item, $start = -10, $stop = 0)

        :param $item:
        :param $start:
        :param $stop:
