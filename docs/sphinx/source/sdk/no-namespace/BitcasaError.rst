------------
BitcasaError
------------

.. php:namespace:

.. php:class:: BitcasaError

    .. php:attr:: message

        protected

    .. php:attr:: code

        protected

    .. php:attr:: file

        protected

    .. php:attr:: line

        protected

    .. php:method:: __construct($status)

        Initilizes the Bitcasa Error instance.

        :type $status: string
        :param $status: The error status.

    .. php:method:: get_status()

        Retrieves the error status.

        :returns: string The error status.

    .. php:method:: __clone()

    .. php:method:: getMessage()

    .. php:method:: getCode()

    .. php:method:: getFile()

    .. php:method:: getLine()

    .. php:method:: getTrace()

    .. php:method:: getPrevious()

    .. php:method:: getTraceAsString()

    .. php:method:: __toString()
