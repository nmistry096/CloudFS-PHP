-------------
BitcasaStatus
-------------

.. php:namespace:

.. php:class:: BitcasaStatus

    Bitcasa Client PHP SDK
    Copyright (C) 2014 Bitcasa, Inc.

    This file contains an SDK in PHP for accessing the Bitcasa infinite drive.

    For support, please send email to support@bitcasa.com.

    .. php:method:: __construct($response)

        Initializes the Bitcasa status instance.

        :type $response: object
        :param $response:

    .. php:method:: error_code()

        Retrieves the status error code.

        :returns: The error code.

    .. php:method:: error_message()

        Retrieves the status error message.

        :returns: The error message.

    .. php:method:: success()

        Retrieves the status success status.

        :returns: The success status.

    .. php:method:: throw_on_failure()

        Handles errors according to success status.
