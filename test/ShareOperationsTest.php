<?php

use CloudFS\Filesystem;
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
     * Clears user file system.
     */
    public function testDeleteRootFolders() {
        /** @var \CloudFS\Filesystem $fileSystem */
        $fileSystem = new Filesystem($this->getSession()->getBitcasaClientApi());

        $items = $fileSystem->getList('/');
        if (count($items) > 0) {
            $fileSystem->delete($items, true);
        }
    }

    /**
     * Test share operations.
     */
    public function testShares() {
        $fileSystem = new Filesystem($this->getSession()->getBitcasaClientApi());

        // /top
        /** @var \CloudFS\Item $topLevelFolder */
        $topLevelFolder = $fileSystem->create(null, $this->topLevelFolder, Exists::OVERWRITE);
        $this->assertNotNull($topLevelFolder);
        $this->assertTrue($topLevelFolder->getName() == $this->topLevelFolder);
        $this->assertTrue($topLevelFolder->getType() == FileType::FOLDER);
        $this->assertNotEmpty($topLevelFolder->getId());

        // /top/shared
        $sharedFolder = $topLevelFolder->create($this->sharedFolderName);
        $this->assertNotNull($sharedFolder);
        $this->assertEquals($this->sharedFolderName, $sharedFolder->getName());

        // /top/shared/shared-file
        $localUploadDirectory = dirname(__FILE__) . '/files/upload/';
        $textFileName = 'shared-file';
        $uploadedTextFile = $sharedFolder->upload($localUploadDirectory . 'text', $textFileName, Exists::OVERWRITE);
        $this->assertNotNull($uploadedTextFile);
        $this->assertEquals($textFileName, $uploadedTextFile->getName());

        // /top/receive
        $receivedFolder = $topLevelFolder->create($this->receiveFolderName);
        $this->assertNotNull($receivedFolder);
        $this->assertEquals($this->receiveFolderName, $receivedFolder->getName());

        $shares = $fileSystem->shares();
        if ($shares != null) {
            foreach ($shares as $share) {
                /** @var \CloudFS\Share $share */
                try {
                    $unlocked = $fileSystem->unlockShare($share->getShareKey(), 'password');
                } catch (\Exception $error) {
                }

                try {
                    $unlocked = $fileSystem->unlockShare($share->getShareKey(), 'newPassword');
                } catch (\Exception $error) {
                }

                $share->delete();
            }
        }

        /** @var \CloudFS\Share $share */
        $share = $fileSystem->createShare($sharedFolder->getPath());
        $this->assertNotNull($share);
        $this->assertNotEmpty($share->getShareKey());

        $shares = $fileSystem->shares();
        $this->assertTrue(count($shares) > 0);

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

        $shares = $fileSystem->shares();
        foreach($shares as $sharedItem) {
            if ($sharedItem->getName() == $this->sharedFolderName) {
                $share = $sharedItem;
            }
        }

        $this->assertEquals($this->sharedFolderName, $share->getName());

        $failed = false;
        try {
            $unlocked = $fileSystem->unlockShare($share->getShareKey(), 'password');
        }
        catch(\Exception $error) {
            $failed = true;
        }

        $this->assertTrue($failed);

        $unlocked = $fileSystem->unlockShare($share->getShareKey(), 'newPassword');
        $this->assertTrue($unlocked);

        $deleted = $share->delete();
        $this->assertTrue($deleted);
    }
}