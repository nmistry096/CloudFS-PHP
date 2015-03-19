<?php

use CloudFS\Filesystem;
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
        $level0Folder1 = $this->getItem($restAdapter->getList(), $this->level0Folder1Name);
        if ($level0Folder1 != null) {
            $restAdapter->deleteFolder($level0Folder1->getPath());
        }

        $level0Folder1 = $restAdapter->createFolder(null, $this->level0Folder1Name, Exists::OVERWRITE);
        $this->assertNotNull($level0Folder1);
        $this->assertEquals($this->level0Folder1Name, $level0Folder1->getName());
        $this->assertTrue($level0Folder1->getType() == FileType::FOLDER);
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
        $items = $this->getSession()->getRestAdapter()->getList();
        $this->assertNotNull($items);
        $this->assertTrue(count($items) > 0);
        $folderFound = false;
        foreach ($items as $item) {
            if ($item->getName() == $this->level0Folder1Name) {
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
        $items = $restAdapter->getList();
        $folder = null;
        foreach ($items as $item) {
            if ($item->getName() == $this->level0Folder1Name) {
                $folder = $item;
                break;
            }
        }

        $meta = $restAdapter->getFolderMeta($folder->getPath());
        $this->assertEquals($this->level0Folder1Name, $meta->getName());
    }

    /**
     * The bitcasa folders related tests.
     */
    public function testFolders() {
        /** @var \CloudFS\RESTAdapter $restAdapter */
        $restAdapter = $this->getSession()->getRestAdapter();

        $level0Folder1 = $this->getItem($restAdapter->getList(), $this->level0Folder1Name);
        $this->assertNotNull($level0Folder1);

        $level1Folder1 = $restAdapter->createFolder($level0Folder1->getPath(),
            $this->level1Folder1Name, Exists::OVERWRITE);
        $this->assertNotNull($level1Folder1);
        $this->assertEquals($this->level1Folder1Name, $level1Folder1->getName());

        $level1Folder2 = $restAdapter->createFolder($level0Folder1->getPath(),
            $this->level1Folder2Name, Exists::OVERWRITE);
        $this->assertNotNull($level1Folder2);
        $this->assertEquals($this->level1Folder2Name, $level1Folder2->getName());

        $level2Folder1 = $restAdapter->createFolder($level1Folder2->getPath(),
            $this->level2Folder1Name, Exists::OVERWRITE);
        $this->assertNotNull($level2Folder1);
        $this->assertEquals($this->level2Folder1Name, $level2Folder1->getName());

        $meta = $restAdapter->getFolderMeta($level2Folder1->getPath());
        $this->assertEquals($this->level2Folder1Name, $meta->getName());

        $newName = 'Moved ' . $this->level2Folder1Name;
        $movedFolder = $restAdapter->moveFolder($level2Folder1->getPath(), $level1Folder1->getPath(),
            $newName, Exists::OVERWRITE);
        $this->assertNotNull($movedFolder);
        $this->assertEquals($newName, $movedFolder->getName());

        $this->assertNotNull($this->getItem($restAdapter->getList($level1Folder1->getPath()), $newName));
        $this->assertNull($this->getItem($restAdapter->getList($level1Folder2->getPath()), $this->level2Folder1Name));

        $copiedFolder = $restAdapter->copyFolder($movedFolder->getPath(), $level1Folder2->getPath(),
            $this->level2Folder1Name, Exists::OVERWRITE);
        $this->assertEquals($this->level2Folder1Name, $copiedFolder->getName());
        $this->assertNotNull($this->getItem($restAdapter->getList($level1Folder1->getPath()), $newName));
        $this->assertNotNull($this->getItem($restAdapter->getList($level1Folder2->getPath()), $this->level2Folder1Name));

        $deleted = $restAdapter->deleteFolder($movedFolder->getPath());
        $this->assertTrue($deleted);
        $this->assertNull($this->getItem($restAdapter->getList($level1Folder1->getPath()), $newName));
        $this->assertNotNull($this->getItem($restAdapter->getList($level1Folder2->getPath()), $this->level2Folder1Name));
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
        $level0Folder1 = $this->getItem($restAdapter->getList(), $this->level0Folder1Name);

        $level1Folder3 = $restAdapter->createFolder($level0Folder1->getPath(), $this->level1Folder3Name, Exists::OVERWRITE);
        $this->assertNotNull($level1Folder3);
        $this->assertEquals($this->level1Folder3Name, $level1Folder3->getName());

        $level1Folder4 = $restAdapter->createFolder($level0Folder1->getPath(), $this->level1Folder4Name, Exists::OVERWRITE);
        $this->assertNotNull($level1Folder4);
        $this->assertEquals($this->level1Folder4Name, $level1Folder4->getName());

        $textFileName = 'file1';
        $uploadedTextFile = $restAdapter->uploadFile($level1Folder3->getPath(), $textFileName,
            $localUploadDirectory . 'text', Exists::OVERWRITE);
        $this->assertNotNull($uploadedTextFile);
        $this->assertEquals($textFileName, $uploadedTextFile->getName());

        $meta = $restAdapter->getFileMeta($uploadedTextFile->getPath());
        $this->assertEquals($textFileName, $meta->getName());

        $localDestinationPath = $localDownloadDirectory . 'file1';
        $status = $restAdapter->downloadFile($uploadedTextFile->getPath(), $localDestinationPath, null);
        $this->assertTrue($status);

        $imageFileName = 'image1.jpg';
        $uploadedImageFile = $restAdapter->uploadFile($level1Folder4->getPath(), $imageFileName,
            $localUploadDirectory . 'image.jpg', Exists::OVERWRITE);
        $this->assertNotNull($uploadedImageFile);
        $this->assertEquals($imageFileName, $uploadedImageFile->getName());

        $localDestinationPath = $localDownloadDirectory . 'image1.jpg';
        $status = $restAdapter->downloadFile($uploadedImageFile->getPath(), $localDestinationPath, null);
        $this->assertTrue($status);

        $newName = 'Moved' . $uploadedImageFile->getName();
        $movedFile = $restAdapter->moveFile($uploadedImageFile->getPath(), $level1Folder3->getPath(),
            $newName, Exists::OVERWRITE);
        $this->assertNotNull($movedFile);
        $this->assertEquals($newName, $movedFile->getName());

        $copiedFile = $restAdapter->copyFile($movedFile->getPath(), $level1Folder4->getPath(),
            $imageFileName, Exists::OVERWRITE);
        $this->assertNotNull($copiedFile);
        $this->assertEquals($imageFileName, $copiedFile->getName());

        $deletedFile = $restAdapter->deleteFile($movedFile->getPath());
        $this->assertTrue($deletedFile);

        $this->assertNotNull($this->getItem($restAdapter->getList($level1Folder3->getPath()), $textFileName));
        $this->assertNotNull($this->getItem($restAdapter->getList($level1Folder4->getPath()), $imageFileName));
    }
}