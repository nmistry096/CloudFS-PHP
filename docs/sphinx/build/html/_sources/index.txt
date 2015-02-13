.. highlight:: php5

=========================================
CloudFS PHP SDK User Guide
=========================================
.. contents:: Contents
   :depth: 2
|

API Reference
~~~~~~~~~~~~~~~

Refer the :ref:`Phpdoc <cloudfs-sdk>` documentation to view class and method details.

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

You can assert whether a user is linked to the session.
  ::

    $session.isLinked();

The currently linked user can be unlinked from the session.
  ::

    $session.unlink();

File System Operations
----------------------
.. note:: You need to create a session in order to perform file system operations.

  - :php:meth:`Get Root Folder <Filesystem::getFolder>`
      ::

      $fileSystem = new Filesystem($session->getBitcasaClientApi());
      $root = $fileSystem->getFolder();


  - :php:meth:`Get Specific Folder <Filesystem::getFolder>`
      ::

      $folder = $fileSystem->getFolder($pathOfFolder);


  - :php:meth:`Get Specific File <Filesystem::getFile>`
      ::

      $file = $fileSystem->getFile($pathOfFile);


  - :php:meth:`List Items <Filesystem::getList>`

    You can list down the contents of a Folder. Below example shows how to retrieve contents of the root folder.

      ::

	  $items = $fileSystem->getList();


  - :php:meth:`Copy Items <Filesystem::copy>`

    You can copy a list of items to a new location in the file system. If the contents in the destination folder conflicts with the copying items you can either RENAME, OVERWRITE, REUSE or FAIL the operation.

      ::

      $items = $fileSystem->copy(array($item1, $item2), $destinationPath, Exists::OVERWRITE);


  - :php:meth:`Move Items <Filesystem::move>`

    You can move a list of items to a new location in the file system. If the contents in the destination folder conflicts with the moving items you can either RENAME, OVERWRITE, REUSE or FAIL the operation.

      ::

      $items = $fileSystem->move(array($item1, $item2), $destinationPath, Exists::OVERWRITE);


  - :php:meth:`Delete Items <Filesystem::delete>`

    You can specify a list of items that needs to be deleted. This will return a list of Success/fail status of each item once the operation completes.

      ::

      $items = $fileSystem->delete(array($item1, $item2));


Folder Operations
-----------------
.. note:: You need to create a session in order to perform folder operations.

  - :php:meth:`List Folder Contents <Folder::get_list>`

    You can list the contents of a folder. This will return a list of top level folders and items in the specified folder.

      ::

      $items = $folder->get_list();


  - :php:meth:`Copy Folder <Item::copy_to>`

    You can copy a folder to a new location in the file system. If the destination conflicts with the copying folder you can either RENAME, OVERWRITE, REUSE or FAIL the operation.

      ::

      $newFolder = $folder->copy_to($destinationPath, Exists::OVERWRITE);


  - :php:meth:`Move Folder <Item::move_to>`

    You can move a folder to a new location in the file system. If the destination conflicts with the moving folder you can either RENAME, OVERWRITE, REUSE or FAIL the operation.

      ::

      $newFolder = $folder->move_to($destinationPath, Exists::OVERWRITE);


  - :php:meth:`Delete Folder <Item::delete>`

    You can perform the delete operation on a folder. This will return the Success/fail status of the operation.

      ::

      $status = $folder->delete();


  - :php:meth:`Create Sub Folder <Container::create>`

    You can create a sub folder in a specific folder. If the folder already has a sub folder with the given name, the operation will fail.

      ::

      $subFolder = $folder.create($subFolderName);


  - :php:meth:`Upload File <Folder::upload>`

    You can upload a file from your local file system into a specific folder. If the destination conflicts, you can either RENAME, OVERWRITE, REUSE or FAIL the operation.

      ::

      $file = $folder->upload($localFilePath, $fileName, Exists::OVERWRITE);


File Operations
---------------
.. note:: You need to create a session in order to perform file operations.

  - :php:meth:`Copy File <Item::copy_to>`

    You can copy a file to a new location in the file system. If the destination conflicts with the copying file you can either RENAME, OVERWRITE, REUSE or FAIL the operation.

      ::

      $newFile = $file->copy_to($destinationPath, Exists::OVERWRITE);


  - :php:meth:`Move File <Item::move_to>`

    You can move a file to a new location in the file system. If the destination conflicts with the moving file you can either RENAME, OVERWRITE, REUSE or FAIL the operation.

      ::

      $newFile = $file->move_to($destinationPath, Exists::OVERWRITE);


  - :php:meth:`Delete File <Item::delete>`

    You can perform the delete operation on a file. This will return the Success/fail status of the operation.

      ::

      $status = $file->delete();


  - :php:meth:`Download File <Item::delete>`

    You can download a file to your local file system.

      ::

      $content = $fileSystem->download($file);





