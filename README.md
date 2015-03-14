# Bitcasa SDK for PHP
  
The **Bitcasa SDK for PHP** enables PHP developers to easily work with [Bitcasa 
Cloud Storage Platform](https://www.bitcasa.com/) and build scalable solutions.

* [REST API Documentation](https://www.bitcasa.com/cloudfs-api-docs/)
* [Blog](http://blog.bitcasa.com/) 

## Getting Started

If you have already [signed up](https://www.bitcasa.com/cloudfs/pricing) and obtained your credentials you can get started in minutes.

There are two main methods of getting the CloudFS-PHP SDK.

1. Cloning the git repository.

  ```bash
  $ git clone https://github.com/bitcasa/CloudFS-PHP.git
  ```
  
2. Adding the CloudFS-PHP SDK package name to composer by editing `composer.json`.

  ```
  "require": {
      "bitcasa/cloudfs-sdk": "dev-develop"
    }
  ```
For the composer package to run, you should have [composer](https://getcomposer.org/) installed.

## Using the SDK

Use the credentials you obtained from Bitcasa admin console to create a client session. This session can be used for all future requests to Bitcasa.

```php
$session = new Session("bitcasa.cloudfs.io", CLIENT_ID, CLIENT_SECRET); 
$res = $session->authenticate("myaccount@domain", "mypassword");
```

Getting the root folder

```php
//Folder root = session.getFileSystem().getRoot();
```

Getting the contents of root folder

```php
//Item[] itemArray = session.getFileSystem().list("");
```
or
```php
//Item[] itemArray = session.getFileSystem().list(root);
```

Deleting the contents of root folder

```php
//session.getFileSystem().delete(itemArray);
```

Uploading a file to root folder

```php
//root.upload(pathOfFile, Exists.FAIL, listener);
```

Download a file from root folder

```php
//File fileToDownload = session.getFileSystem().getFile(pathOfFileToDownload);
//fileToDownload.download(localDestinationPath, listener);
```

Create user (for paid accounts only)

```php
//AdminSession adminSession = new AdminSession(adminEndPoint, adminClientId, adminClientSecret);
//Profile profile = adminSession.admin().createAccount(username, password, email, firstName, lastName);
```

## Running the Tests

Before running the tests, you should add the API credentials found in your CloudFS account to the file \test\BaseTest.php

You should have PHPUnit installed to run the tests. The instructions to download and install PHPUnit can be found at https://phpunit.de/ 

>>WARNING!!! Never run the test suite against a production environment. It deletes all the contents of the file system.

To execute the tests go the test directory and run:
```
phpunit <TestName>.php
```


We would love to hear what features or functionality you're interested in, or general comments on the SDK (good and bad - especially bad).

