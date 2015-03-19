<?php

use CloudFS\Utils\Exists;
use CloudFS\Utils\FileType;

class ShareOperationsTest extends BaseTest {

    private $topLevelFolder = 'top';
    private $sharedFolderName = 'shared';
    private $sharedAlterFolderName = 'shared-altered';
    private $receiveFolderName = 'received';

    /**
     * The session authenticate test. Needs to authenticate before doing any other operations.
     */
    public function testAuthenticate(){
        $this->getSession()->authenticate(self::USERNAME, self::PASSWORD);
        $this->assertTrue(true, $this->getSession()->isLinked());
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

        // /top/shared
        $sharedFolder = $topLevelFolder->createFolder($this->sharedFolderName);
        $this->assertNotNull($sharedFolder);
        $this->assertEquals($this->sharedFolderName, $sharedFolder->getName());

        // /top/shared/shared-file
        $localUploadDirectory = dirname(__FILE__) . '/files/upload/';
        $textFileName = 'shared-file';
        $uploadedTextFile = $sharedFolder->upload($localUploadDirectory . 'text', null, Exists::OVERWRITE);
        $this->assertNotNull($uploadedTextFile);

        // /top/receive
        $receivedFolder = $topLevelFolder->createFolder($this->receiveFolderName);
        $this->assertNotNull($receivedFolder);
        $this->assertEquals($this->receiveFolderName, $receivedFolder->getName());

        /** @var \CloudFS\Share $share */
        $path = array($sharedFolder->getPath(), $receivedFolder->getPath());
        //$path = $receivedFolder->getPath();
        $share = $fileSystem->createShare($path);
        $this->assertNotNull($share);
        $this->assertNotEmpty($share->getShareKey());

        $shares = $fileSystem->listShares();
        $this->assertTrue(count($shares) > 0);

        $sharedItem = $fileSystem->retrieveShare($share->getShareKey());
        $this->assertEquals($share->getShareKey(), $sharedItem->getShareKey());

        $items = $share->getList();
        $this->assertTrue(count($items) > 0);

        $received = $share->receive($receivedFolder->getPath());
        $this->assertTrue($received);

        $items = $receivedFolder->getList();
        $this->assertTrue(count($items) > 0);

        $altered = $share->setName($this->sharedAlterFolderName);
        $this->assertTrue($altered);

        $altered = $share->setPassword('password');
        $this->assertTrue($altered);

        $altered = $share->changeAttributes(
            array('name' => $this->sharedFolderName, 'password' => 'newPassword'),
            'password');
        $this->assertTrue($altered);

        $shares = $fileSystem->listShares();
        foreach($shares as $sharedItem) {
            if ($sharedItem->getName() == $this->sharedFolderName) {
                $share = $sharedItem;
            }
        }

        $this->assertEquals($this->sharedFolderName, $share->getName());

        $deleted = $share->delete();
        $this->assertTrue($deleted);

        $topLevelFolder->delete(true, true);
    }
}