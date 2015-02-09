.. highlight:: php5

=========================================
CloudFS PHP SDK User Guide
=========================================
.. contents:: Contents
   :depth: 2
|

API Reference
~~~~~~~~~~~~~~~

Refer the :ref:`Phpdoc <my-label>` documentation to view class and method details.

|

Getting the SDK
~~~~~~~~~~~~~~~~

You can download the SDK from github.

.. code-block:: bash

	git clone https://github.com/bitcasa/CloudFS-PHP
|

Using the SDK
~~~~~~~~~~~~~~~~~~~~~~~~~
If you don't have a CloudFS API account, |register_link| to gain access.

.. |register_link| raw:: html

   <a href="https://www.bitcasa.com/" target="_blank">register</a>


Creating and linking the CloudFS Sessions
-----------------------------------------
Sessions represent connections to CloudFS. They use a set of credentials that consists of an end point URL,
a client ID and a client secret. These credentials can be obtained via the Bitcasa admin console.

:php:class:`Session`  - Performs regular file system operations.
  ::

   $session = new Session($endPoint, $clientId, $clientSecret);


A user can be linked to the session by authenticating using a username and a password.
   ::

   $session->authenticate($username, $password);




