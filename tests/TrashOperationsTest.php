<?php

use CloudFS\Utils\Exists;
use CloudFS\Utils\RestoreMethod;

class TrashOperationsTest extends BaseTest {

    private $level0Folder1Name = 'level-0-trashFolder-1';
    private $level1Folder1Name = 'level-1-trashFolder-1';

    /**
     * The session authenticate test. Needs to authenticate before doing any other operations.
     */
    public function testAuthenticate() {
        $this->getSession()->authenticate(self::USERNAME, self::PASSWORD);
        $this->assertTrue(true, $this->getSession()->isLinked());
    }

    /**
     * Test emptying trash.
     */
    public function testEmptyTrash() {
        $fileSystem = $this->getSession()->filesystem();
        $items = $fileSystem->listTrash();
        $restAdapter = $this->getSession()->getRestAdapter();
        foreach($items as $item) {
            $restAdapter->deleteTrashItem($item->getPath());
        }
    }

    /**
     * Test trash related operations.
     */
    public function testTrash() {
        $fileSystem = $this->getSession()->filesystem();
        $items = $fileSystem->listTrash();
        $root = $fileSystem->root();

        $level0Folder1 = $root->createFolder($this->level0Folder1Name);
        $this->assertEquals($this->level0Folder1Name, $level0Folder1->getName());

        $level1Folder1 = $level0Folder1->createFolder($this->level1Folder1Name);
        $this->assertEquals($this->level1Folder1Name, $level1Folder1->getName());

        $localUploadDirectory = dirname(__FILE__) . '/files/upload/';
        $file = $level0Folder1->upload($localUploadDirectory . 'text2', null, Exists::OVERWRITE);
        $this->assertEquals('text2', $file->getName());

        $deleted = $level0Folder1->delete(false, true);
        $this->assertTrue($deleted);

        $items = $fileSystem->listTrash();
        $this->assertTrue(count($items) > 0);
        foreach($items as $item) {
            if ($item->getType() == \CloudFS\Utils\FileType::FOLDER) {
                $subItems = $item->getList();
                $this->assertTrue(count($subItems) >= 0);
            }
        }
    }

    /**
     * Test file restore related operations.
     */
    public function testRestore() {
        $fileSystem = $this->getSession()->filesystem();
        $root = $fileSystem->root();

        $level0Folder1 = $root->createFolder($this->level0Folder1Name);

        $localDownloadDirectory = dirname(__FILE__) . '/files/download/';
        $this->checkedAndCreateDirName($localDownloadDirectory);
        $localUploadDirectory = dirname(__FILE__) . '/files/upload/';

        $articleFile = $level0Folder1->upload($localUploadDirectory . 'text2', null, Exists::OVERWRITE);
        $articleFile->delete();

        $response = $articleFile->restore($level0Folder1->getPath(), RestoreMethod::RECREATE);
        $this->assertTrue($response);

        $localDestinationPath = dirname(__FILE__) . '/files/download/article';
        $status = $articleFile->download($localDestinationPath, null);
        $this->assertTrue($status);
    }
}