----------------------
CloudFS\\Utils\\Assert
----------------------

.. php:namespace: CloudFS\\Utils

.. php:class:: Assert

    .. php:method:: assertNonNull($s, $argno = 0)

        Check if a supplied argument in null or not.

        :type $s: mixed
        :param $s: The argument to validate.
        :type $argno: int
        :param $argno: The argument number to pass to InvalidArgument.
        :returns: bool The null status of the argument supplied.

    .. php:method:: assertString($s, $argno = 0)

        Check if a supplied argument is of type string or not.

        :type $s: mixed
        :param $s: The argument to validate.
        :type $argno: int
        :param $argno: The argument number to pass to InvalidArgument.
        :returns: bool The string  status of the argument supplied.

    .. php:method:: assertStringOrNull($s, $argno = 0)

        Check if a supplied argument is null or of type string.

        :type $s: mixed
        :param $s: The argument to validate.
        :type $argno: int
        :param $argno: The argument number to pass to InvalidateArgument.
        :returns: bool The string or null status of the argument supplied.

    .. php:method:: assertNumber($s, $argno = 0)

        Check if a supplied argument is a number or not.

        :type $s: mixed
        :param $s: The argument to validate.
        :type $argno: int
        :param $argno: The argument number to pass to InvalidateArgument.
        :returns: bool The number status of the argument supplied.

    .. php:method:: assertPath($s, $argno = 0)

        :param $s:
        :param $argno:
