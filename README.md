# Bitcasa SDK for PHP
  
The **Bitcasa SDK for PHP** enables PHP developers to easily work with [Bitcasa Cloud Storage Platform](https://www.bitcasa.com/) and build scalable solutions.

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
$session = new Session($endPoint, $clientId, $clientSecret);
$session->authenticate("myaccount@domain", "mypassword");
```

Getting the root folder

```php
$root = $session->filesystem()->root();
```

Getting the contents of root folder

```php
$items = $root->getList();
```

Creating a subfolder under root folder

```php
$folder = $root->createFolder($folderName);
```
Uploading a file to a folder

```php
$folder->upload($pathOfFile, $fileName, Exists::OVERWRITE);
```

Download a file from a folder

```php
$file = $folder->getFile($filePath);
$file->download($localDownloadDirectory . $fileName);
```

Deleting a file or folder

```php
$item->delete();
```

Create user (for paid accounts only)

```php
$session->setAdminCredentials($adminId, $adminSecret);
$user = $session->createAccount($username, $password, email, $firstName, $lastName);
```

## Running the Tests

Before running the tests, you should add the API credentials found in your CloudFS account to the file \tests\BaseTest.php

If you used the clone method to download the SDK you should have PHPUnit installed to run the tests. The instructions to download and install PHPUnit can be found at https://phpunit.de/ 

>>WARNING!!! Never run the test suite against a production environment. It deletes all the contents of the file system.

To execute the tests go the root source code directory and run:
```
phpunit
```

We would love to hear what features or functionality you're interested in, or general comments on the SDK (good and bad - especially bad).

