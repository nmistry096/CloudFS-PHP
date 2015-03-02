
# Bitcasa SDK for PHP Beta Release 0.6  
  
The initial release of **Bitcasa SDK for PHP** enables PHP developers to easily work with [Bitcasa 
Cloud Storage Platform](https://www.bitcasa.com/) and build scalable solutions.  
Unfortunately the functionality is far from complete.

* [REST API Documentation](https://www.bitcasa.com/cloudfs-api-docs/)
* [Blog](http://blog.bitcasa.com/) 

#Current Functionality
This release supports a subset of CloudFS functionality. Most
operations with files and folders are supported, though objects cannot
be restored from the trash. Reaching full REST functionality is
expected to happen in the next few weeks.

Here are the major missing features:

- User Creation
- Call to BitcasaFIlesystem::download() returns the content of the
  file. This will change to have the caller supply a file name.
- File Version History is untested
- Retore from Trash is untested
- PHP-SDK specific functionality is also planned once the REST interface is implemented.
- Test files for this particular SDK.
  
## Getting Started

If you have already [signed up](https://www.bitcasa.com/cloudfs/pricing) and obtained your credentials you can get started in minutes.

## Using the SDK

Use the credentials you obtained from Bitcasa admin console to create a client session. This session can be used for all future requests to Bitcasa.

```php
<?php
require_once "BitcasaApi.php"; 
require_once "BitcasaFilesystem.php";

$session = new Session("bitcasa.cloudfs.io", CLIENT_ID, CLIENT_SECRET); 
?>
```

List Contents of a folder.

```php
<?php

require_once "BitcasaApi.php"; 
require_once "BitcasaFilesystem.php";

$session = new Session("bitcasa.cloudfs.io", CLIENT_ID, CLIENT_SECRET); 
$res = $session->authenticate("myaccount@domain", "mypassword"); 
$fs = $session->filesystem(); $api = $session->getClientApi();

$parent = "/";

try { 
        $items = $fs->getList($parent); 
        foreach ($items as $i) 
        { 
            print $i->name() . "\t" . $i->id() . "\n"; 
        } 
} 
catch (Exception $e) 
{ 
    print $e->getMessage(); 
}

?>
```

Upload a file to a folder.

```php
<?
require_once "BitcasaApi.php";
require_once "BitcasaFilesystem.php";

$session = new Session("bitcasa.cloudfs.io", CLIENT_ID, CLIENT_SECRET);
$res = $session->authenticate("myaccount@domain", "mypassword");
$fs = $session->filesystem();
$api = $session->getClientApi();

$parent = "/";

try {
    $file = "/tmp/hello.txt";
    $item = $fs->upload($parent, $file);
    print $item->name() . ": " . $item->id();
} catch (Exception $e) {
    print $e->getMessage();
}

?>
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
