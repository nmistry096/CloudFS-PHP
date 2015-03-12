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
        $fileSystem = $this->getSession()->filesystem();
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
        $fileSystem = $this->getSession()->filesystem();
        $items = $fileSystem->getList(null);
        $this->assertTrue(count($items) > 0);
        $level0Folder1 = $this->getItemFromIndexArray($items, $this->level0Folder1Name);
        $this->assertEquals($this->level0Folder1Name, $level0Folder1->getName());
    }

    /**
     * The create sub folders test.
     */
    public function testCreateSubFolders() {
        $fileSystem = $this->getSession()->filesystem();
        $root = $fileSystem->root();
        $this->assertNotNull($root);

        $level0Folder1 = $root->createFolder($this->level0Folder1Name);
        $this->assertNotNull($level0Folder1);
        $this->assertEquals($this->level0Folder1Name, $level0Folder1->getName());

        $level1Folder1 = $level0Folder1->createFolder($this->level1Folder1Name);
        $this->assertEquals($this->level1Folder1Name, $level1Folder1->getName());

        $level1Folder2 = $level0Folder1->createFolder($this->level1Folder2Name);
        $this->assertEquals($this->level1Folder2Name, $level1Folder2->getName());

        $level2Folder1 = $fileSystem->create($level1Folder1->getPath(), $this->level2Folder1Name, Exists::OVERWRITE);
        $this->assertEquals($this->level2Folder1Name, $level2Folder1->getName());

        $level2Folder2 = $fileSystem->create($level1Folder1->getPath(), $this->level2Folder2Name, Exists::OVERWRITE);
        $this->assertEquals($this->level2Folder2Name, $level2Folder2->getName());

        $movedItems1 = $fileSystem->move(array($level2Folder1), $level1Folder2->getPath(), Exists::OVERWRITE);
        $this->assertTrue(count($movedItems1) > 0);

        $movedItems2 = $level2Folder2->move($level1Folder2->getPath(), Exists::OVERWRITE);
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
        $copiedItems2 = $level2Folder2->copy($level1Folder1->getPath(), Exists::OVERWRITE);
        $this->assertTrue(count($copiedItems2) > 0);
        $this->assertEquals($this->level2Folder2Name, $copiedItems2[0]['result']['meta']['name']);

        $deletedItems1 = $fileSystem->delete(array($level2Folder1));
        $deletedItems2 = $level2Folder2->delete(true, true);

        $items1 = $fileSystem->getList($level1Folder1->getPath());
        $this->assertTrue(count($items1) == 2);
        $items2 = $level1Folder2->getList();
        $this->assertTrue(count($items2) == 0);
    }

    /**
     * The bitcasa files related tests.
     */
    public function testFiles() {
        $fileSystem = $this->getSession()->filesystem();
        $level0Folder1 = $this->getItemFromIndexArray($fileSystem->getList('/'), $this->level0Folder1Name);

        $level1Folder3 = $level0Folder1->createFolder($this->level1Folder3Name);
        $this->assertNotNull($level1Folder3);
        $this->assertEquals($this->level1Folder3Name, $level1Folder3->getName());

        $level1Folder4 = $level0Folder1->createFolder($this->level1Folder4Name);
        $this->assertNotNull($level1Folder4);
        $this->assertEquals($this->level1Folder4Name, $level1Folder4->getName());

        $localUploadDirectory = dirname(__FILE__) . '/files/upload/';
        $textFileName = 'file1';
        $uploadedTextFile = $level1Folder3->upload($localUploadDirectory . 'text', $textFileName, Exists::OVERWRITE);
        $this->assertNotNull($uploadedTextFile);
        $this->assertEquals($textFileName, $uploadedTextFile->getName());

        $file = $fileSystem->getFile($uploadedTextFile->getPath());
        //$item = $fileSystem->getItem($uploadedTextFile->getPath());
        $this->assertEquals($textFileName, $file->getName());
        //$this->assertEquals($textFileName, $item->getName());

        $localDownloadDirectory = dirname(__FILE__) . '/files/download/';

        $uploadedTextFile->download($localDownloadDirectory . 'image-download.jpg');
        $content = file_get_contents($localDownloadDirectory . 'image-download.jpg');
        $this->assertNotEmpty($content);

        $downloadedTextFile = $fileSystem->download($uploadedTextFile);
        $this->assertNotEmpty($downloadedTextFile);

        file_put_contents($localDownloadDirectory . 'file1', $downloadedTextFile);

        $imageFileName = 'image1.jpg';
        $uploadedImageFile = $fileSystem->upload($level1Folder4->getPath(),
            $localUploadDirectory . 'image.jpg', $imageFileName, Exists::OVERWRITE);
        $this->assertNotNull($uploadedImageFile);
        $this->assertEquals($imageFileName, $uploadedImageFile->getName());

        $this->assertEquals('jpg', $uploadedImageFile->getExtension());
        $this->assertNotNull($uploadedImageFile->getSize());
        $this->assertEquals('image/jpeg',$uploadedImageFile->getMime());

        $newImageName = 'newimage.jpg';
        $uploadedImageFile->setName($newImageName);
        $uploadedImageFile->setMime('image/jpeg');
        $version = $uploadedImageFile->getVersion();
        $uploadedImageFile->setVersion($version);
        $savedFile = $uploadedImageFile->save();

        $this->assertEquals($newImageName,$savedFile[0]['result']['name']);
        $this->assertEquals('image/jpeg',$savedFile[0]['result']['mime']);
        $uploadedImageFile->setName($imageFileName);
        $uploadedImageFile->setVersion($savedFile[0]['result']['version']);
        $uploadedImageFile->save();
        $versions = $uploadedImageFile->versions();

        $this->assertTrue(count($versions['result']) == 2);

        $content = $uploadedImageFile->read();

        $downloadedImageFile = $fileSystem->download($uploadedImageFile);
        $this->assertNotEmpty($downloadedImageFile);
        file_put_contents($localDownloadDirectory . 'image1.jpg', $downloadedImageFile);

        $movedFile = $uploadedImageFile->move($level1Folder3->getPath(), Exists::OVERWRITE);
        $this->assertNotNull($movedFile);

        $items = $fileSystem->getList($level1Folder3->getPath());
        $this->assertTrue(count($items) > 0);

        $imageFile = $this->getItemFromIndexArray($items, $imageFileName);
        $this->assertNotNull($imageFile);

        $copiedFile = $imageFile->copy($level1Folder4->getPath(), Exists::OVERWRITE);
        $this->assertNotNull($copiedFile);
        $this->assertEquals($imageFileName, $copiedFile[0]['result']['meta']['name']);

        $deletedFile = $imageFile->delete();

        $this->assertNotNull($this->getItemFromIndexArray($fileSystem->getList($level1Folder3->getPath()), $textFileName));
        $this->assertNotNull($this->getItemFromIndexArray($fileSystem->getList($level1Folder4->getPath()), $imageFileName));
    }


    /**
     * Test alter operations on files and folders.
     */
    public function testAlterOperations() {
        /** @var \CloudFS\Filesystem $fileSystem */
        $fileSystem = $this->getSession()->filesystem();
        /** @var \CloudFS\Folder $root */
        $root = $fileSystem->root();
        /** @var \CloudFS\Folder $folder */
        $folder = $root->createFolder($this->level0Folder1Name);
        $newName = 'altered-folder-name';
        $folder->setName($newName);

        $folder = $fileSystem->getFolder($folder->getPath());
        $this->assertEquals($newName, $folder->getName());

        $localUploadDirectory = dirname(__FILE__) . '/files/upload/';
        /** @var \CloudFS\File $file */
        $file = $folder->upload($localUploadDirectory . 'text', 'original-name', Exists::OVERWRITE);
        $file->setName('altered-name');

        $file = $fileSystem->getFile($file->getPath());
        $this->assertEquals('altered-name', $file->getName());

        $deleted = $folder->delete(true, true);
        $this->assertTrue($deleted);
    }
}