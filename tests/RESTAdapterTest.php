<?php

use CloudFS\Utils\Exists;
use CloudFS\Utils\FileType;

/**
 * Test Bitcasa rest adapter related tests.
 */
class RESTAdapterTest extends BaseTest {

    private $level0Folder1Name = 'level-0-folder-1';
    private $level1Folder1Name = 'level-1-folder-1';
    private $level1Folder2Name = 'level-1-folder-2';
    private $level1Folder3Name = 'level-1-folder-3';
    private $level1Folder4Name = 'level-1-folder-4';
    private $level2Folder1Name = 'level-2-folder-1';

    /**
     * The session authenticate test.
     */
    public function testAuthenticate() {
        $this->getSession()->authenticate(self::USERNAME, self::PASSWORD);
        $this->assertTrue(true, $this->getSession()->isLinked());
    }

    /**
     * The create root folder test.
     */
    public function testCreateRootFolder() {
        /** @var \CloudFS\RESTAdapter $restAdapter */
        $restAdapter = $this->getSession()->getRestAdapter();
        $level0Folder1 = $this->getItemFromAssociativeArray($restAdapter->getList(), $this->level0Folder1Name);
        if ($level0Folder1 != null) {
            $restAdapter->deleteFolder($this->getPathFromAssociativeArray($level0Folder1), true, true);
        }

        $level0Folder1 = $restAdapter->createFolder(null, $this->level0Folder1Name, Exists::OVERWRITE);
        $this->assertNotNull($level0Folder1);
        $item = $level0Folder1['result']['items'][0];
        $this->assertArrayHasKey('name', $item);
        $this->assertTrue($item['name'] == $this->level0Folder1Name);
        $this->assertTrue($item['type'] == FileType::FOLDER);
        $this->assertNotEmpty($item['id']);
        $this->assertEmpty($item['parent_id']);
        
    }

    /**
     * @expectedException Exception
     * @expectedExceptionCode 409
     */
    public function testCreateRootFolderFailIfExists() {
        $this->getSession()->getRestAdapter()->createFolder(null, $this->level0Folder1Name, Exists::FAIL);
    }

    /**
     * Get the root folder item list.
     */
    public function testListRootFolder() {
        $result = $this->getSession()->getRestAdapter()->getList();
        $this->assertNotNull($result);
        $this->assertNull($result['error']);
        $this->assertArrayHasKey('result', $result);
        $meta = $result['result']['meta'];
        $this->assertTrue($meta['type'] == FileType::ROOT);
        $items = $result['result']['items'];
        $this->assertTrue(count($items) > 0);
        $folderFound = false;
        foreach($items as $item) {
            if ($item['name'] == $this->level0Folder1Name) {
                $folderFound = true;
                break;
            }
        }

        $this->assertTrue($folderFound);
    }

    /**
     * Retrieve folder meta data.
     */
    public function testFolderMeta() {
        /** @var \CloudFS\RESTAdapter $restAdapter */
        $restAdapter = $this->getSession()->getRestAdapter();
        $result = $restAdapter->getList();
        $items = $result['result']['items'];
        $folder = null;
        foreach($items as $item) {
            if ($item['name'] == $this->level0Folder1Name) {
                $folder = $item;
                break;
            }
        }

        $path = $this->getPathFromAssociativeArray($folder);
        $meta = $this->getSession()->getRestAdapter()->getFolderMeta($path);
        $this->assertEquals($this->level0Folder1Name, $meta['result']['meta']['name']);
    }

    /**
     * The bitcasa folders related tests.
     */
    public function testFolders() {
        /** @var \CloudFS\RESTAdapter $restAdapter */
        $restAdapter = $this->getSession()->getRestAdapter();

        $level0Folder1 = $this->getItemFromAssociativeArray($restAdapter->getList(), $this->level0Folder1Name);
        $this->assertNotNull($level0Folder1);
        $level0Folder1Path = $this->getPathFromAssociativeArray($level0Folder1);

        $level1Folder1 = $restAdapter->createFolder($level0Folder1Path, $this->level1Folder1Name, Exists::OVERWRITE);
        $this->assertNotNull($level1Folder1);
        $this->assertEquals($this->level1Folder1Name, $level1Folder1['result']['items'][0]['name']);
        $level1Folder1Path = $this->getPathFromAssociativeArray($level1Folder1['result']['items'][0], $level0Folder1Path);

        $level1Folder2 = $restAdapter->createFolder($level0Folder1Path, $this->level1Folder2Name, Exists::OVERWRITE);
        $this->assertNotNull($level1Folder2);
        $this->assertEquals($this->level1Folder2Name, $level1Folder2['result']['items'][0]['name']);
        $level1Folder2Path = $this->getPathFromAssociativeArray($level1Folder2['result']['items'][0], $level0Folder1Path);

        $level2Folder1 = $restAdapter->createFolder($level1Folder2Path, $this->level2Folder1Name, Exists::OVERWRITE);
        $this->assertNotNull($level2Folder1);
        $this->assertEquals($this->level2Folder1Name, $level2Folder1['result']['items'][0]['name']);
        $level2Folder1Path = $this->getPathFromAssociativeArray($level2Folder1['result']['items'][0], $level1Folder2Path);

        $meta = $restAdapter->getFolderMeta($level2Folder1Path);
        $this->assertEquals($this->level2Folder1Name, $meta['result']['meta']['name']);

        $newName = 'Moved ' . $this->level2Folder1Name;
        $movedFolder = $restAdapter->moveFolder($level2Folder1Path, $level1Folder1Path, $newName, Exists::OVERWRITE);
        $this->assertNotNull($movedFolder);
        $this->assertEquals($newName, $movedFolder['result']['meta']['name']);
        $newPath = $this->getPathFromAssociativeArray($movedFolder['result']['meta'], $level1Folder1Path);

        $this->assertNotNull($this->getItemFromAssociativeArray($restAdapter->getList($level1Folder1Path), $newName));
        $this->assertNull($this->getItemFromAssociativeArray($restAdapter->getList($level1Folder2Path), $this->level2Folder1Name));

        $copiedFolder = $restAdapter->copyFolder($newPath, $level1Folder2Path, $this->level2Folder1Name, Exists::OVERWRITE);
        $this->assertEquals($this->level2Folder1Name, $copiedFolder['result']['meta']['name']);
        $this->assertNotNull($this->getItemFromAssociativeArray($restAdapter->getList($level1Folder1Path), $newName));
        $this->assertNotNull($this->getItemFromAssociativeArray($restAdapter->getList($level1Folder2Path), $this->level2Folder1Name));

        $deletedFolder = $restAdapter->deleteFolder($newPath);
        $this->assertTrue($deletedFolder);
        $this->assertNull($this->getItemFromAssociativeArray($restAdapter->getList($level1Folder1Path), $newName));
        $this->assertNotNull($this->getItemFromAssociativeArray($restAdapter->getList($level1Folder2Path), $this->level2Folder1Name));
    }

    /**
     * The bitcasa files related tests.
     */
    public function testFiles() {
        $localUploadDirectory = dirname(__FILE__) . '/files/upload/';
        $localDownloadDirectory = dirname(__FILE__) . '/files/download/';
        $this->checkedAndCreateDirName($localUploadDirectory);

        /** @var \CloudFS\RESTAdapter $restAdapter */
        $restAdapter = $this->getSession()->getRestAdapter();
        $level0Folder1 = $this->getItemFromAssociativeArray($restAdapter->getList(), $this->level0Folder1Name);
        $level0Folder1Path = $this->getPathFromAssociativeArray($level0Folder1);

        $level1Folder3 = $restAdapter->createFolder($level0Folder1Path, $this->level1Folder3Name, Exists::OVERWRITE);
        $this->assertNotNull($level1Folder3);
        $this->assertEquals($this->level1Folder3Name, $level1Folder3['result']['items'][0]['name']);
        $level1Folder3Path = $this->getPathFromAssociativeArray($level1Folder3['result']['items'][0], $level0Folder1Path);

        $level1Folder4 = $restAdapter->createFolder($level0Folder1Path, $this->level1Folder4Name, Exists::OVERWRITE);
        $this->assertNotNull($level1Folder4);
        $this->assertEquals($this->level1Folder4Name, $level1Folder4['result']['items'][0]['name']);
        $level1Folder4Path = $this->getPathFromAssociativeArray($level1Folder4['result']['items'][0], $level0Folder1Path);

        $localUploadDirectory = dirname(__FILE__) . '/files/upload/';
        $textFileName = 'file1';
        $uploadedTextFile = $restAdapter->uploadFile($level1Folder3Path, $textFileName,
            $localUploadDirectory . 'text', Exists::OVERWRITE);
        $this->assertNotNull($uploadedTextFile);
        $this->assertEquals($textFileName, $uploadedTextFile['result']['name']);
        $uploadedTextFilePath = $this->getPathFromAssociativeArray($uploadedTextFile['result'], $level1Folder3Path);

        $meta = $restAdapter->getFileMeta($uploadedTextFilePath);
        $this->assertEquals($textFileName, $meta['result']['name']);

        $localDestinationPath = $localDownloadDirectory . 'file1';
        $status = $restAdapter->downloadFile($uploadedTextFilePath, $localDestinationPath, null);
        $this->assertTrue($status);

        $imageFileName = 'image1.jpg';
        $uploadedImageFile = $restAdapter->uploadFile($level1Folder4Path, $imageFileName,
            $localUploadDirectory . 'image.jpg', Exists::OVERWRITE);
        $this->assertNotNull($uploadedImageFile);
        $this->assertEquals($imageFileName, $uploadedImageFile['result']['name']);
        $uploadedImageFilePath = $this->getPathFromAssociativeArray($uploadedImageFile['result'], $level1Folder4Path);

        $localDestinationPath = $localDownloadDirectory . 'image1.jpg';
        $status = $restAdapter->downloadFile($uploadedImageFilePath, $localDestinationPath, null);
        $this->assertTrue($status);

        $newName = 'Moved' . $uploadedImageFile['result']['name'];
        $movedFile = $restAdapter->moveFile($uploadedImageFilePath, $level1Folder3Path, $newName, Exists::OVERWRITE);
        $this->assertNotNull($movedFile);
        $this->assertEquals($newName, $movedFile['result']['meta']['name']);
        $newPath = $this->getPathFromAssociativeArray($movedFile['result']['meta'], $level1Folder3Path);

        $copiedFile = $restAdapter->copyFile($newPath, $level1Folder4Path, $imageFileName, Exists::OVERWRITE);
        $this->assertNotNull($copiedFile);
        $this->assertEquals($imageFileName, $copiedFile['result']['meta']['name']);

        $deletedFile = $restAdapter->deleteFile($newPath);
        $this->assertTrue($deletedFile);

        $this->assertNotNull($this->getItemFromAssociativeArray($restAdapter->getList($level1Folder3Path), $textFileName));
        $this->assertNotNull($this->getItemFromAssociativeArray($restAdapter->getList($level1Folder4Path), $imageFileName));

    }
}