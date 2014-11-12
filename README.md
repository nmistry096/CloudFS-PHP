
CloudFS-PHP Beta Release 0.6
============================

Initial release of the PHP SDK for CloudFS. This release allows
developers get started building CloudFS-based
applications. Unfortunately the functionality is far from complete.


Current Functionality
---------------------

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

Example to list content of a folder
-----------------------------------

<?php

require_once "BitcasaApi.php";
require_once "BitcasaFilesystem.php";

$session = new Session("bitcasa.cloudfs.io", CLIENT_ID, CLIENT_SECRET);
$res = $session->authenticate("myaccount@domain", "mypassword");
$fs = $session->filesystem();
$api = $session->getClientApi();

$parent = "/";

try {
    $items = $fs->getList($parent);
    foreach ($items as $i) {
        print $i->name() . "\t" . $i->id() . "\n";
    }
} catch (Exception $e) {
    print $e->getMessage();
}

?>

Example to upload a file
------------------------

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


We would love to hear what features or functionality you're interested in, or general comments on the SDK (good and bad - especially bad).