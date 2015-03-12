---------------------------------
CloudFS\\Exception\\BitcasaStatus
---------------------------------

.. php:namespace: CloudFS\\Exception

.. php:class:: BitcasaStatus

    Class BitcasaStatus
    Handles bitcasa status responses.

    .. php:method:: __construct($response)

        Initializes the Bitcasa status instance.

        :type $response: object
        :param $response:

    .. php:method:: errorCode()

        Retrieves the status error code.

        :returns: The error code.

    .. php:method:: errorMessage()

        Retrieves the status error message.

        :returns: The error message.

    .. php:method:: success()

        Retrieves the status success status.

        :returns: The success status.

    .. php:method:: throwOnFailure()

        Handles errors according to success status.
