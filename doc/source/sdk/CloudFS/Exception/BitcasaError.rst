--------------------------------
CloudFS\\Exception\\BitcasaError
--------------------------------

.. php:namespace: CloudFS\\Exception

.. php:class:: BitcasaError

    Class BitcasaError
    Handles the bitcasa error responses.

    .. php:attr:: message

        protected

    .. php:attr:: code

        protected

    .. php:attr:: file

        protected

    .. php:attr:: line

        protected

    .. php:method:: __construct($status)

        Initializes the Bitcasa Error instance.

        :type $status: BitcasaStatus
        :param $status: The error status.

    .. php:method:: getStatus()

        Retrieves the error status.

        :returns: The error status.

    .. php:method:: __clone()

    .. php:method:: getMessage()

    .. php:method:: getCode()

    .. php:method:: getFile()

    .. php:method:: getLine()

    .. php:method:: getTrace()

    .. php:method:: getPrevious()

    .. php:method:: getTraceAsString()

    .. php:method:: __toString()
