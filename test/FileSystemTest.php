<?php

use CloudFS\Filesystem;
use CloudFS\Utils\Exists;
use CloudFS\Utils\FileType;

/**
 * Test Bitcasa file system related functionality.
 */
class FileSystemTest extends BaseTest {

    private $level0Folder1Name = 'level-0-folder-1';
    private $level1Folder1Name = 'level-1-folder-1';
    private $level1Folder2Name = 'level-1-folder-2';
    private $level1Folder3Name = 'level-1-folder-3';
    private $level1Folder4Name = 'level-1-folder-4';
    private $level2Folder1Name = 'level-2-folder-1';
    private $level2Folder2Name = 'level-2-folder-2';
    private $sharedFolderName = 'shared';
    private $receiveSharedFolderName = 'received';

    /**
     * The session authenticate test.
     */
    public function testAuthenticate(){
        $this->getSession()->authenticate(self::USERNAME, self::PASSWORD);
        $this->assertTrue(true, $this->getSession()->isLinked());
    }

    /**
     * The create root folder test.
     */
    public function testCreateRootFolder() {
        $fileSystem = new Filesystem($this->getSession()->getBitcasaClientApi());
        $items = $fileSystem->getList('/');
        $level0Folder1 = $this->getItemFromIndexArray($items, $this->level0Folder1Name);
        if ($level0Folder1 != null) {
            $level0Folder1->delete(true, true);
        }

        $level0Folder1 = $fileSystem->create(null, $this->level0Folder1Name, Exists::OVERWRITE);
        /** @var \CloudFS\Item $level0Folder1 */
        $this->assertNotNull($level0Folder1);
        $this->assertTrue($level0Folder1->getName() == $this->level0Folder1Name);
        $this->assertTrue($level0Folder1->getType() == FileType::FOLDER);
        $this->assertNotEmpty($level0Folder1->getId());
    }

    /**
     * The list root folder test.
     */
    public function testListRootFolder() {
        $fileSystem = new Filesystem($this->getSession()->getBitcasaClientApi());
        $items = $fileSystem->getList(null);
        $this->assertTrue(count($items) > 0);
        $level0Folder1 = $this->getItemFromIndexArray($items, $this->level0Folder1Name);
        $this->assertEquals($this->level0Folder1Name, $level0Folder1->getName());
    }

    /**
     * The create sub folders test.
     */
    public function testCreateSubFolders() {
        $fileSystem = new Filesystem($this->getSession()->getBitcasaClientApi());
        $root = $fileSystem->getFolder(null);
        $this->assertNotNull($root);
        $this->assertEquals(FileType::ROOT, $root->getType());

        $level0Folder1 = $root->create($this->level0Folder1Name);
        $this->assertNotNull($level0Folder1);
        $this->assertEquals($this->level0Folder1Name, $level0Folder1->getName());

        $level1Folder1 = $level0Folder1->create($this->level1Folder1Name);
        $this->assertEquals($this->level1Folder1Name, $level1Folder1->getName());

        $level1Folder2 = $level0Folder1->create($this->level1Folder2Name);
        $this->assertEquals($this->level1Folder2Name, $level1Folder2->getName());

        $level2Folder1 = $fileSystem->create($level1Folder1->getPath(), $this->level2Folder1Name, Exists::OVERWRITE);
        $this->assertEquals($this->level2Folder1Name, $level2Folder1->getName());

        $level2Folder2 = $fileSystem->create($level1Folder1->getPath(), $this->level2Folder2Name, Exists::OVERWRITE);
        $this->assertEquals($this->level2Folder2Name, $level2Folder2->getName());

        $movedItems1 = $fileSystem->move(array($level2Folder1), $level1Folder2->getPath(), Exists::OVERWRITE);
        $this->assertTrue(count($movedItems1) > 0);

        $movedItems2 = $level2Folder2->move_to($level1Folder2->getPath(), Exists::OVERWRITE);
        $this->assertTrue(count($movedItems2) > 0);

        $items1 = $fileSystem->getList($level1Folder2->getPath());
        $this->assertTrue(count($items1) > 0);

        $items2 = $fileSystem->getList($level1Folder1->getPath());
        $this->assertTrue(count($items2) == 0);

        $level2Folder1 = $this->getItemFromIndexArray($items1, $this->level2Folder1Name);
        $this->assertNotNull($level2Folder1);
        $level2Folder2 = $this->getItemFromIndexArray($items1, $this->level2Folder2Name);
        $this->assertNotNull($level2Folder2);

        $copiedItems1 = $fileSystem->copy(array($level2Folder1), $level1Folder1->getPath(), Exists::OVERWRITE);
        $this->assertTrue(count($copiedItems1) > 0);
        $this->assertEquals($this->level2Folder1Name, $copiedItems1[0]['result']['meta']['name']);
        $copiedItems2 = $level2Folder2->copy_to($level1Folder1->getPath(), Exists::OVERWRITE);
        $this->assertTrue(count($copiedItems2) > 0);
        $this->assertEquals($this->level2Folder2Name, $copiedItems2[0]['result']['meta']['name']);

        $deletedItems1 = $fileSystem->delete(array($level2Folder1));
        $deletedItems2 = $level2Folder2->delete(true, true);

        $items1 = $fileSystem->getList($level1Folder1->getPath());
        $this->assertTrue(count($items1) == 2);
        $items2 = $level1Folder2->get_list();
        $this->assertTrue(count($items2) == 0);
    }

    /**
     * The bitcasa files related tests.
     */
    public function testFiles() {
        $fileSystem = new Filesystem($this->getSession()->getBitcasaClientApi());
        $level0Folder1 = $this->getItemFromIndexArray($fileSystem->getList('/'), $this->level0Folder1Name);

        $level1Folder3 = $level0Folder1->create($this->level1Folder3Name);
        $this->assertNotNull($level1Folder3);
        $this->assertEquals($this->level1Folder3Name, $level1Folder3->getName());

        $level1Folder4 = $level0Folder1->create($this->level1Folder4Name);
        $this->assertNotNull($level1Folder4);
        $this->assertEquals($this->level1Folder4Name, $level1Folder4->getName());

        $localUploadDirectory = dirname(__FILE__) . '/files/upload/';
        $textFileName = 'file1';
        $uploadedTextFile = $level1Folder3->upload($localUploadDirectory . 'text', $textFileName, Exists::OVERWRITE);
        $this->assertNotNull($uploadedTextFile);
        $this->assertEquals($textFileName, $uploadedTextFile->getName());

        $file = $fileSystem->getFile($uploadedTextFile->getPath());
        $this->assertEquals($textFileName, $file->getName());

        $downloadedTextFile = $fileSystem->download($uploadedTextFile);
        $this->assertNotEmpty($downloadedTextFile);
        $localDownloadDirectory = dirname(__FILE__) . '/files/download/';
        file_put_contents($localDownloadDirectory . 'file1', $downloadedTextFile);

        $imageFileName = 'image1.jpg';
        $uploadedImageFile = $fileSystem->upload($level1Folder4->getPath(),
            $localUploadDirectory . 'image.jpg', $imageFileName, Exists::OVERWRITE);
        $this->assertNotNull($uploadedImageFile);
        $this->assertEquals($imageFileName, $uploadedImageFile->getName());

        $downloadedImageFile = $fileSystem->download($uploadedImageFile);
        $this->assertNotEmpty($downloadedImageFile);
        file_put_contents($localDownloadDirectory . 'image1.jpg', $downloadedImageFile);

        $movedFile = $uploadedImageFile->move_to($level1Folder3->getPath(), Exists::OVERWRITE);
        $this->assertNotNull($movedFile);

        $items = $fileSystem->getList($level1Folder3->getPath());
        $this->assertTrue(count($items) > 0);

        $imageFile = $this->getItemFromIndexArray($items, $imageFileName);
        $this->assertNotNull($imageFile);

        $copiedFile = $imageFile->copy_to($level1Folder4->getPath(), Exists::OVERWRITE);
        $this->assertNotNull($copiedFile);
        $this->assertEquals($imageFileName, $copiedFile[0]['result']['meta']['name']);

        $deletedFile = $imageFile->delete();

        $this->assertNotNull($this->getItemFromIndexArray($fileSystem->getList($level1Folder3->getPath()), $textFileName));
        $this->assertNotNull($this->getItemFromIndexArray($fileSystem->getList($level1Folder4->getPath()), $imageFileName));
    }

    public function testShares() {
        $fileSystem = new Filesystem($this->getSession()->getBitcasaClientApi());
        $root = $fileSystem->getFolder(null);
        $this->assertNotNull($root);
        $this->assertEquals(FileType::ROOT, $root->getType());

        $sharedFolder = $root->create($this->sharedFolderName);
        $this->assertNotNull($sharedFolder);
        $this->assertEquals($this->sharedFolderName, $sharedFolder->getName());

        $receivedFolder = $root->create($this->receiveSharedFolderName);
        $this->assertNotNull($receivedFolder);
        $this->assertEquals($this->receiveSharedFolderName, $receivedFolder->getName());

        $localUploadDirectory = dirname(__FILE__) . '/files/upload/';
        $textFileName = 'shared-file';
        $uploadedTextFile = $sharedFolder->upload($localUploadDirectory . 'text', $textFileName, Exists::OVERWRITE);
        $this->assertNotNull($uploadedTextFile);
        $this->assertEquals($textFileName, $uploadedTextFile->getName());

        $share = $fileSystem->createShare($sharedFolder->getPath());
        /** @var \CloudFS\Share $share */
        $this->assertNotNull($share);
        $this->assertNotEmpty($share->getShareKey());

        $shares = $fileSystem->shares();
        $this->assertTrue(count($shares) > 0);

        $items = $fileSystem->browseShare($share->getShareKey());
        $this->assertTrue(count($items) > 0);

        $received = $fileSystem->retrieveShare($share->getShareKey(), $receivedFolder->getPath());
        $this->assertTrue($received);

        $items = $receivedFolder->get_list();
        $this->assertTrue(count($items) > 0);

        $deleted = $fileSystem->deleteShare($share->getShareKey());
        $this->assertTrue($deleted);
    }

}