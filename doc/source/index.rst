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

Admin Operations
----------------
.. note:: You need to set the admin credentials in order to perform admin operations.
  You can create end users for an admin/paid account. If 'logInToCreatedUser' is true, logs in to the user after creating it.

- :php:meth:`Create Account <Session::createAccount>`
      ::

      $session->setAdminCredentials($this::ADMIN_ID, $this::ADMIN_SECRET);
      $user = $session->createAccount($username, $password, $email, $firstName, $lastName, $logInToCreatedUser);

File System Operations
----------------------
.. note:: You need to create a session in order to perform file system operations.

- :php:meth:`Get Root Folder <Filesystem::root>`
      ::

      $fileSystem = new Filesystem($session->getRestAdapter());
      $root = $fileSystem->root();


- :php:meth:`Get Specific Item <Filesystem::getItem>`
      ::

      $file = $fileSystem->getItem($pathOfFile);


- :php:meth:`List Trash Items <Filesystem::listTrash>`

  You can list down the contents of Trash folder. Below example shows how to retrieve contents of the trash folder.
 
      ::

      $trash = $fileSystem->listTrash();


- :php:meth:`Get Shares <Filesystem::listShares>`

  You can list down available Shares. Below example shows how to retrieve the list of shares.
 
      ::

      $items = $fileSystem->listShares();


- :php:meth:`Create Share <Filesystem::createShare>`

  You can create a share by providing the path as shown in below example. A passworded share cannot be used for anything if the password is not provided. It doesn't make sense to create a share unless the developer has the password.
 
      ::

      $share = $fileSystem->createShare($itemToShare->getPath());


- :php:meth:`Get Specific Share <Filesystem::retrieveShare>`

  You can get a share by providing the share key and the password (If available). A passworded share cannot be used for anything if the password is not provided.
 
      ::

      $share = $fileSystem->retrieveShare($shareKey);


Folder Operations
-----------------
.. note:: You need to create a session in order to perform folder operations.

- :php:meth:`List Folder Contents <Folder::getList>`

  You can list the contents of a folder. This will return a list of top level folders and items in the specified folder.

      ::

      $items = $folder->getList();


- :php:meth:`Change Folder Attributes <Folder::changeAttributes>`

  You can change the attributes of a Folder by providing a hash map of field names and values. An example is given below.
      ::

      $folder->changeAttributes(array('application_data' => $newApplicationData, 'version' => $this->getVersion()));

   	 
- :php:meth:`Copy Folder <Folder::copy>`

  You can copy a folder to a new location in the file system. If the destination conflicts with the copying folder you can either RENAME, OVERWRITE or FAIL the operation.

      ::

      $newFolder = $folder->copy($destinationPath, Exists::OVERWRITE);


- :php:meth:`Move Folder <Folder::move>`

  You can move a folder to a new location in the file system. If the destination conflicts with the moving folder you can either RENAME, OVERWRITE or FAIL the operation.

      ::

      $newFolder = $folder->move($destinationPath, Exists::OVERWRITE);


- :php:meth:`Delete Folder <Folder::delete>`

  You can perform the delete operation on a folder. This will return the Success/fail status of the operation.

      ::

      $status = $folder->delete();


- :php:meth:`Restore Folder <Folder::restore>`

  You can restore a Folder from the trash. The restore method can be set to either FAIL, RESCUE or RECREATE. This will return the Success/failure status of the operation.

      ::    

      $status = $folder->restore($items, $destination, Exists::Rename);


- :php:meth:`Create Sub Folder <Folder::createFolder>`

  You can create a sub folder in a specific folder. If the folder already has a sub folder with the given name, the operation will fail.

      ::

      $subFolder = $folder->createFolder($subFolderName);


- :php:meth:`Upload File <Folder::upload>`

  You can upload a file from your local file system into a specific folder. If the destination conflicts, you can either RENAME, OVERWRITE or FAIL the operation.

      ::

      $file = $folder->upload($localFilePath, $uploadProgressCallback, Exists::OVERWRITE);


File Operations
---------------
.. note:: You need to create a session in order to perform file operations.

- :php:meth:`Change File Attributes <File::changeAttributes>`

  You can change the attributes of a File by providing a hash map of field names and values. An example is given below.
      ::

      $file->changeAttributes(array('application_data' => $newApplicationData));

   	 
- :php:meth:`Copy File <File::copy>`

  You can copy a file to a new location in the file system. If the destination conflicts with the copying file you can either RENAME, OVERWRITE or FAIL the operation.

      ::

      $newFile = $file->copy($destinationPath, Exists::OVERWRITE);


- :php:meth:`Move File <File::move>`

  You can move a file to a new location in the file system. If the destination conflicts with the moving file you can either RENAME, OVERWRITE or FAIL the operation.

      ::

      $newFile = $file->move($destinationPath, Exists::OVERWRITE);


- :php:meth:`Delete File <File::delete>`

  You can perform the delete operation on a file. This will return the Success/fail status of the operation.

      ::

      $status = $file->delete();


- :php:meth:`Restore File <File::restore>`

  You can restore files from the trash. The restore method can be set to either FAIL, RESCUE or RECREATE. This will return the Success/failure status of the operation.

      ::    

      $status = $file->restore($destination, RestoreMethod::FAIL);


- :php:meth:`Download File <File::download>`

  You can download a file to your local file system.

      ::

      $content = $file->download($localDestinationPath, $downloadProgressCallback);


Share Operations
-----------------
.. note:: You need to create a session in order to perform share operations.

- :php:meth:`Change Share Attributes <Share::changeAttributes>`

  You can change the attributes of a Share by providing a hash map of field names and values. An example is given below.

      ::

      $share->changeAttributes(array('name' => $this->sharedFolderName, 'password' => 'newPassword'), 'password');


- :php:meth:`Receive Share <Share::receive>`

  Receives all share files to the given path.
      ::

      $share->receive($path);

 
- :php:meth:`Delete Share <Share::delete>`

      ::    

      $share.delete();

- :php:meth:`Set Share Password <Share::setPassword>`

  Sets the share password. Old password is only needed if one exists.
      ::

      $share->setPassword('password');

 
