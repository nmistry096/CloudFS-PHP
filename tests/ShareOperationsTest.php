<?php

use CloudFS\Utils\Exists;
use CloudFS\Utils\FileType;

class ShareOperationsTest extends BaseTest {

    private $topLevelFolder = 'top';
    private $sharedFolder1Name = 'shared1';
    private $sharedFolder2Name = 'shared2';
    private $sharedAlterFolderName = 'shared-altered';
    private $receiveFolderName = 'received';

    /**
     * The session authenticate test. Needs to authenticate before doing any other operations.
     */
    public function testAuthenticate() {
        $this->getSession()->authenticate(self::USERNAME, self::PASSWORD);
        $this->assertTrue(true, $this->getSession()->isLinked());
    }

    /**
     * Test to delete existing shares.
     */
    public function testDeleteShares() {
        /** @var \CloudFS\Filesystem $fileSystem */
        $fileSystem = $this->getSession()->filesystem();
        $shares = $fileSystem->listShares();
        foreach($shares as $share) {
            /** @var \CloudFS\Share $share */
            $share->delete();
        }
    }

    /**
     * Test share operations.
     */
    public function testShares() {
        /** @var \CloudFS\Filesystem $fileSystem */
        $fileSystem = $this->getSession()->filesystem();
        $root = $fileSystem->root();

        // /top
        /** @var \CloudFS\Folder $topLevelFolder */
        $topLevelFolder = $root->createFolder($this->topLevelFolder, Exists::OVERWRITE);
        $this->assertNotNull($topLevelFolder);
        $this->assertTrue($topLevelFolder->getName() == $this->topLevelFolder);
        $this->assertTrue($topLevelFolder->getType() == FileType::FOLDER);
        $this->assertNotEmpty($topLevelFolder->getId());

        // /top/shared1
        $sharedFolder1 = $topLevelFolder->createFolder($this->sharedFolder1Name);
        $this->assertNotNull($sharedFolder1);
        $this->assertEquals($this->sharedFolder1Name, $sharedFolder1->getName());

        $sharedFolder2 = $topLevelFolder->createFolder($this->sharedFolder2Name);
        $this->assertNotNull($sharedFolder2);
        $this->assertEquals($this->sharedFolder2Name, $sharedFolder2->getName());

        // /top/shared1/shared-file
        $localUploadDirectory = dirname(__FILE__) . '/files/upload/';
        $uploadedTextFile = $sharedFolder1->upload($localUploadDirectory . 'text', null, Exists::OVERWRITE);
        $this->assertNotNull($uploadedTextFile);

        // /top/receive
        $receivedFolder = $topLevelFolder->createFolder($this->receiveFolderName);
        $this->assertNotNull($receivedFolder);
        $this->assertEquals($this->receiveFolderName, $receivedFolder->getName());

        /** @var \CloudFS\Share $share */
        $share = $fileSystem->createShare(array($sharedFolder1->getPath(), $sharedFolder2->getPath()));
        $this->assertNotNull($share);
        $this->assertNotEmpty($share->getShareKey());

        $shares = $fileSystem->listShares();
        $this->assertTrue(count($shares) > 0);

        $sharedItem = $fileSystem->retrieveShare($share->getShareKey());
        $this->assertEquals($share->getShareKey(), $sharedItem->getShareKey());

        $items = $share->getList();
        $this->assertTrue(count($items) > 0);

        foreach($items as $item) {
            /** @var \CloudFS\Item $item */
            if ($item->getType() == FileType::FOLDER) {
                $subItems = $item->getList();
                $this->assertTrue(count($subItems) >= 0);
            }
        }

        $received = $share->receive($receivedFolder->getPath());
        $this->assertTrue($received);

        $items = $receivedFolder->getList();
        $this->assertTrue(count($items) > 0);

        $receivedItems = $items[0]->getList();
        $this->assertTrue(count($receivedItems) == 2);

        $altered = $share->setName($this->sharedAlterFolderName);
        $this->assertTrue($altered);

        $altered = $share->changeAttributes(
            array('name' => $this->sharedFolder1Name));
        $this->assertTrue($altered);

        $shares = $fileSystem->listShares();
        foreach ($shares as $sharedItem) {
            if ($sharedItem->getName() == $this->sharedFolder1Name) {
                $share = $sharedItem;
            }
        }

        $this->assertEquals($this->sharedFolder1Name, $share->getName());

        $deleted = $share->delete();
        $this->assertTrue($deleted);

        $topLevelFolder->delete(true, true);
    }
}