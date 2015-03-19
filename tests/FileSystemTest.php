<?php

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
     * Clears the root folders.
     */
    public function testDeleteRootLevelFolder() {
        /** @var \CloudFS\Filesystem $fileSystem */
        $fileSystem = $this->getSession()->filesystem();
        $root = $fileSystem->root();

        $items = $root->getList();
        if (count($items) > 0) {
            foreach($items as $item) {
                /** @var \CloudFS\Item $item */
                if ($item->getName() == $this->level0Folder1Name) {
                    $item->delete(true, true);
                }
            }
        }
    }

    /**
     * The create root folder test.
     */
    public function testCreateRootFolder() {
        $fileSystem = $this->getSession()->filesystem();
        $root = $fileSystem->root();
        $items = $root->getList();
        $level0Folder1 = $this->getItem($items, $this->level0Folder1Name);
        if ($level0Folder1 != null) {
            $level0Folder1->delete(true, true);
        }

        $level0Folder1 = $root->createFolder($this->level0Folder1Name, Exists::OVERWRITE);
        /** @var \CloudFS\Item $level0Folder1 */
        $this->assertNotNull($level0Folder1);
        $this->assertTrue($level0Folder1->getName() == $this->level0Folder1Name);
        $this->assertTrue($level0Folder1->getType() == FileType::FOLDER);
        $this->assertNotEmpty($level0Folder1->getId());
    }
//
//    /**
//     * The list root folder test.
//     */
//    public function testListRootFolder() {
//        $fileSystem = $this->getSession()->filesystem();
//        $root = $fileSystem->root();
//        $items = $root->getList();
//        $this->assertTrue(count($items) > 0);
//        $level0Folder1 = $this->getItem($items, $this->level0Folder1Name);
//        $this->assertEquals($this->level0Folder1Name, $level0Folder1->getName());
//    }
//
//    /**
//     * The create sub folders test.
//     */
//    public function testCreateSubFolders() {
//        $fileSystem = $this->getSession()->filesystem();
//        $root = $fileSystem->root();
//        $this->assertNotNull($root);
//
//        $level0Folder1 = $root->createFolder($this->level0Folder1Name);
//        $this->assertNotNull($level0Folder1);
//        $this->assertEquals($this->level0Folder1Name, $level0Folder1->getName());
//
//        $level1Folder1 = $level0Folder1->createFolder($this->level1Folder1Name);
//        $this->assertEquals($this->level1Folder1Name, $level1Folder1->getName());
//
//        $level1Folder2 = $level0Folder1->createFolder($this->level1Folder2Name);
//        $this->assertEquals($this->level1Folder2Name, $level1Folder2->getName());
//
//        $level2Folder1 = $level1Folder1->createFolder($this->level2Folder1Name, Exists::OVERWRITE);
//        $this->assertEquals($this->level2Folder1Name, $level2Folder1->getName());
//
//        $level2Folder2 = $level1Folder1->createFolder($this->level2Folder2Name, Exists::OVERWRITE);
//        $this->assertEquals($this->level2Folder2Name, $level2Folder2->getName());
//
//        $movedItem1 = $level2Folder1->move($level1Folder2->getPath(), Exists::OVERWRITE);
//        $this->assertEquals($this->level2Folder1Name, $movedItem1->getName());
//
//        $movedItem2 = $level2Folder2->move($level1Folder2->getPath(), Exists::OVERWRITE);
//        $this->assertEquals($this->level2Folder2Name, $movedItem2->getName());
//
//        $items1 = $level1Folder2->getList();
//        $this->assertTrue(count($items1) > 0);
//
//        $items2 = $level1Folder1->getList();
//        $this->assertTrue(count($items2) == 0);
//
//        $level2Folder1 = $this->getItem($items1, $this->level2Folder1Name);
//        $this->assertNotNull($level2Folder1);
//        $level2Folder2 = $this->getItem($items1, $this->level2Folder2Name);
//        $this->assertNotNull($level2Folder2);
//
//        $copiedItem1 = $level2Folder1->copy($level1Folder1->getPath(), Exists::OVERWRITE);
//        $this->assertNotNull($copiedItem1);
//        $this->assertEquals($this->level2Folder1Name, $copiedItem1->getName());
//
//        $copiedItem2 = $level2Folder2->copy($level1Folder1->getPath(), Exists::OVERWRITE);
//        $this->assertNotNull($copiedItem2);
//        $this->assertEquals($this->level2Folder2Name, $copiedItem2->getName());
//
//        $deletedItem1 = $level2Folder1->delete(true, true);
//        $this->assertTrue($deletedItem1);
//        $deletedItem2 = $level2Folder2->delete(true, true);
//        $this->assertTrue($deletedItem2);
//
//        $items1 = $level1Folder1->getList();
//        $this->assertTrue(count($items1) == 2);
//        $items2 = $level1Folder2->getList();
//        $this->assertTrue(count($items2) == 0);
//    }

//    /**
//     * The bitcasa files related tests.
//     */
//    public function testFiles() {
//        $localUploadDirectory = dirname(__FILE__) . '/files/upload/';
//        $localDownloadDirectory = dirname(__FILE__) . '/files/download/';
//        $this->checkedAndCreateDirName($localDownloadDirectory);
//
//        $fileSystem = $this->getSession()->filesystem();
//        $root = $fileSystem->root();
//        $this->assertNotNull($root);
//        $level0Folder1 = $this->getItem($root->getList(), $this->level0Folder1Name);
//
//        $level1Folder3 = $level0Folder1->createFolder($this->level1Folder3Name);
//        $this->assertNotNull($level1Folder3);
//        $this->assertEquals($this->level1Folder3Name, $level1Folder3->getName());
//
//        $level1Folder4 = $level0Folder1->createFolder($this->level1Folder4Name);
//        $this->assertNotNull($level1Folder4);
//        $this->assertEquals($this->level1Folder4Name, $level1Folder4->getName());
//
//        $uploadedTextFile = $level1Folder3->upload($localUploadDirectory . 'text', null, Exists::OVERWRITE);
//        $this->assertNotNull($uploadedTextFile);
//
//        $file = $fileSystem->getItem($uploadedTextFile->getPath());
//        $this->assertNotNull($file);
//
//        $status = $uploadedTextFile->download($localDownloadDirectory . 'text-download', null);
//        $this->assertTrue($status);
//        $content = file_get_contents($localDownloadDirectory . 'text-download');
//        $this->assertNotEmpty($content);
//
//        $imageFileName = 'image.jpg';
//        $uploadedImageFile = $level1Folder4->upload($localUploadDirectory . $imageFileName, null, Exists::OVERWRITE);
//        $this->assertNotNull($uploadedImageFile);
//        $this->assertEquals($imageFileName, $uploadedImageFile->getName());
//        $this->assertEquals('jpg', $uploadedImageFile->getExtension());
//        $this->assertNotNull($uploadedImageFile->getSize());
//        $this->assertEquals('image/jpeg',$uploadedImageFile->getMime());
//        $content = $uploadedImageFile->read();
//        $this->assertNotEmpty($content);
//
//        $movedFile = $uploadedImageFile->move($level1Folder3->getPath(), Exists::OVERWRITE);
//        $this->assertNotNull($movedFile);
//
//        $items = $level1Folder3->getList();
//        $this->assertTrue(count($items) > 0);
//
//        $imageFile = $this->getItem($items, $imageFileName);
//        $this->assertNotNull($imageFile);
//
//        $copiedFile = $imageFile->copy($level1Folder4->getPath(), Exists::OVERWRITE);
//        $this->assertNotNull($copiedFile);
//        $this->assertEquals($imageFileName, $copiedFile->getName());
//
//        $deletedFile = $imageFile->delete();
//        $this->assertTrue($deletedFile);
//        $result = $fileSystem->listTrash();
//        $this->assertNotNull($result);
//
//        $this->assertTrue(count($level1Folder3->getList()) > 0);
//        $this->assertTrue(count($level1Folder4->getList()) > 0);
//    }


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
        $subFolder = $folder->createFolder($this->level1Folder1Name);
        $newName = 'altered-folder-name';
        $subFolder->setName($newName);

        $subFolder = $fileSystem->getItem($subFolder->getPath());
        $this->assertEquals($newName, $subFolder->getName());

        $localUploadDirectory = dirname(__FILE__) . '/files/upload/';
        /** @var \CloudFS\File $file */
        $file = $subFolder->upload($localUploadDirectory . 'text', null, Exists::OVERWRITE);
        $file->setName('altered-name');

        $file = $fileSystem->getItem($file->getPath());
        $this->assertEquals('altered-name', $file->getName());

        $file->setName('altered-name-new');
        $file = $fileSystem->getItem($file->getPath());

        $newMime = 'image/png';
        $success = $file->changeAttributes(array('mime' => $newMime));
        $this->assertTrue($success);

        $file = $fileSystem->getItem($file->getPath());
        $this->assertEquals($newMime, $file->getMime());

        $versions = $file->versions();
        $this->assertTrue(count($versions['result']) == 2);

        $deleted = $subFolder->delete(true, true);
        $this->assertTrue($deleted);
    }

    /**
     * Test restore files relate operations.
     */
    public function testRestore(){
        $fileSystem = $this->getSession()->filesystem();
        $root = $fileSystem->root();
        $folder = $root->createFolder($this->level0Folder1Name);
        $localUploadDirectory = dirname(__FILE__) . '/files/upload/';
        $articleFile = $folder->upload($localUploadDirectory . 'text2', null, Exists::OVERWRITE);
        $articleFile->delete();
        $response = $articleFile->restore($articleFile->getPath());
        $this->assertTrue($response);

        $localDestinationPath = dirname(__FILE__) . '/files/download/article';
        $articleFileContent = $fileSystem->download($articleFile->getPath(), $localDestinationPath, null);
        $this->assertNotEmpty($articleFileContent);
    }

    public function testDownloadFile() {
        $fileSystem = $this->getSession()->filesystem();
        $root = $fileSystem->root();
        $this->assertNotNull($root);

        $level0Folder1 = $root->createFolder($this->level0Folder1Name);
        $this->assertNotNull($level0Folder1);
        $this->assertEquals($this->level0Folder1Name, $level0Folder1->getName());

        $localUploadDirectory = dirname(__FILE__) . '/files/upload/';

        $uploadImageFile = $level0Folder1->upload($localUploadDirectory . 'pic1.jpg',
            array($this, 'uploadProgressCallback'), Exists::OVERWRITE);
        $this->assertEquals('pic1.jpg', $uploadImageFile->getName());

        $downloadUrl = $uploadImageFile->downloadUrl();
        $this->assertNotEmpty($downloadUrl);

        $uploadedTextFile = $level0Folder1->upload($localUploadDirectory . 'large',
            array($this, 'uploadProgressCallback'), Exists::OVERWRITE);
        $this->assertNotNull($uploadedTextFile);

        $localDestinationPath = dirname(__FILE__) . '/files/download/' . $uploadImageFile->getName();
        $status = $uploadImageFile->download($localDestinationPath, array($this, 'downloadProgressCallback'));

        $localDestinationPath = dirname(__FILE__) . '/files/download/large';
        $status = $uploadedTextFile->download($localDestinationPath, array($this, 'downloadProgressCallback'));
        $this->assertTrue($status);

        $level0Folder1->delete(true, true);
    }

    function uploadProgressCallback($downloadSize, $downloadedSize, $uploadSize, $uploadedSize)
    {
        if ($uploadSize == 0 ) {
            $progress = 0;
        }
        else {
            $progress = round($uploadedSize * 100 / $uploadSize);
        }
    }

    function downloadProgressCallback($downloadSize, $downloadedSize, $uploadSize, $uploadedSize)
    {
        if ($downloadSize == 0 ) {
            $progress = 0;
        }
        else {
            $progress = round($downloadedSize * 100 / $downloadSize);
        }
    }
}