<?php

require __DIR__ . '/../vendor/autoload.php';

class BitcasaApiTest extends BaseTest {

    private $level0Folder1Name = 'level-0-folder-1';
    private $level1Folder1Name = 'level-1-folder-1';
    private $level1Folder2Name = 'level-1-folder-2';
    private $level1Folder3Name = 'level-1-folder-3';
    private $level1Folder4Name = 'level-1-folder-4';
    private $level1Folder5Name = 'level-1-folder-5';
    private $level2Folder1Name = 'level-2-folder-1';

    public function testAuthenticate(){
        $this->getSession()->authenticate(self::USERNAME, self::PASSWORD);
        $this->assertTrue(true, $this->getSession()->isLinked());
    }

    public function testCreateRootFolder() {
        $api = $this->getSession()->getBitcasaClientApi();
        $level0Folder1 = $this->getItem($api->getList(), $this->level0Folder1Name);
        if ($level0Folder1 != null) {
            $api->deleteFolder($this->getPath($level0Folder1), true);
        }

        $level0Folder1 = $this->getSession()->getBitcasaClientApi()->createFolder(NULL, $this->level0Folder1Name, Exists::OVERWRITE);

        $this->assertNotNull($level0Folder1);
        $this->assertArrayHasKey('name', $level0Folder1);
        $this->assertTrue($level0Folder1['name'] == $this->level0Folder1Name);
        $this->assertTrue($level0Folder1['type'] == FileType::FOLDER);
        $this->assertNotEmpty($level0Folder1['id']);
        $this->assertEmpty($level0Folder1['parent_id']);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionCode 409
     */
    public function testCreateRootFolderFailIfExists() {
        $this->getSession()->getBitcasaClientApi()->createFolder(NULL, $this->level0Folder1Name, Exists::FAIL);
    }

    public function testListRootFolder() {
        $result = $this->getSession()->getBitcasaClientApi()->getList();
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

    public function testFolderMeta() {
        $result = $this->getSession()->getBitcasaClientApi()->getList();
        $items = $result['result']['items'];
        $folder = null;
        foreach($items as $item) {
            if ($item['name'] == $this->level0Folder1Name) {
                $folder = $item;
                break;
            }
        }

        $path = $this->getPath($folder);

        $meta = $this->getSession()->getBitcasaClientApi()->getFolderMeta($path);
        $this->assertEquals($this->level0Folder1Name, $meta['result']['meta']['name']);
    }

    public function testFolders() {
        $api = $this->getSession()->getBitcasaClientApi();

        $level0Folder1 = $this->getItem($api->getList(), $this->level0Folder1Name);
        $this->assertNotNull($level0Folder1);
        $level0Folder1Path = $this->getPath($level0Folder1);

        $level1Folder1 = $api->createFolder($level0Folder1Path, $this->level1Folder1Name, Exists::OVERWRITE);
        $this->assertNotNull($level1Folder1);
        $this->assertEquals($this->level1Folder1Name, $level1Folder1['name']);
        $level1Folder1Path = $this->getPath($level1Folder1, $level0Folder1Path);

        $level1Folder2 = $api->createFolder($level0Folder1Path, $this->level1Folder2Name, Exists::OVERWRITE);
        $this->assertNotNull($level1Folder2);
        $this->assertEquals($this->level1Folder2Name, $level1Folder2['name']);
        $level1Folder2Path = $this->getPath($level1Folder2, $level0Folder1Path);

        $level2Folder1 = $api->createFolder($level1Folder2Path, $this->level2Folder1Name, Exists::OVERWRITE);
        $this->assertNotNull($level2Folder1);
        $this->assertEquals($this->level2Folder1Name, $level2Folder1['name']);
        $level2Folder1Path = $this->getPath($level2Folder1, $level1Folder2Path);

        $meta = $api->getFolderMeta($level2Folder1Path);
        $this->assertEquals($this->level2Folder1Name, $meta['result']['meta']['name']);

        $newName = 'Moved ' . $this->level2Folder1Name;
        $movedFolder = $api->moveFolder($level2Folder1Path, $level1Folder1Path, $newName, Exists::OVERWRITE);
        $this->assertNotNull($movedFolder);
        $this->assertEquals($newName, $movedFolder['result']['meta']['name']);
        $newPath = $this->getPath($movedFolder['result']['meta'], $level1Folder1Path);

        $this->assertNotNull($this->getItem($api->getList($level1Folder1Path), $newName));
        $this->assertNull($this->getItem($api->getList($level1Folder2Path), $this->level2Folder1Name));

        $copiedFolder = $api->copyFolder($newPath, $level1Folder2Path, $this->level2Folder1Name, Exists::OVERWRITE);
        $this->assertEquals($this->level2Folder1Name, $copiedFolder['result']['meta']['name']);
        $this->assertNotNull($this->getItem($api->getList($level1Folder1Path), $newName));
        $this->assertNotNull($this->getItem($api->getList($level1Folder2Path), $this->level2Folder1Name));

        $deletedFolder = $api->deleteFolder($newPath);
        $this->assertTrue($deletedFolder['result']['success']);
        $this->assertNull($this->getItem($api->getList($level1Folder1Path), $newName));
        $this->assertNotNull($this->getItem($api->getList($level1Folder2Path), $this->level2Folder1Name));
    }

    public function testFiles() {
        $api = $this->getSession()->getBitcasaClientApi();
        $level0Folder1 = $this->getItem($api->getList(), $this->level0Folder1Name);
        $level0Folder1Path = $this->getPath($level0Folder1);

        $level1Folder3 = $api->createFolder($level0Folder1Path, $this->level1Folder3Name, Exists::OVERWRITE);
        $this->assertNotNull($level1Folder3);
        $this->assertEquals($this->level1Folder3Name, $level1Folder3['name']);
        $level1Folder3Path = $this->getPath($level1Folder3, $level0Folder1Path);

        $level1Folder4 = $api->createFolder($level0Folder1Path, $this->level1Folder4Name, Exists::OVERWRITE);
        $this->assertNotNull($level1Folder4);
        $this->assertEquals($this->level1Folder4Name, $level1Folder4['name']);
        $level1Folder4Path = $this->getPath($level1Folder4, $level0Folder1Path);

        $localUploadDirectory = dirname(__FILE__) . '/files/upload/';
        $textFileName = 'file1';
        $uploadedTextFile = $api->uploadFile($level1Folder3Path, $textFileName,
            $localUploadDirectory . 'text', Exists::OVERWRITE);
        $this->assertNotNull($uploadedTextFile);
        $this->assertEquals($textFileName, $uploadedTextFile['result']['name']);
        $uploadedTextFilePath = $this->getPath($uploadedTextFile['result'], $level1Folder3Path);

        $meta = $api->getFileMeta($uploadedTextFilePath);
        $this->assertEquals($textFileName, $meta['result']['name']);

        $downloadedTextFile = $api->downloadFile($uploadedTextFilePath);
        $this->assertNotEmpty($downloadedTextFile);
        $localDownloadDirectory = dirname(__FILE__) . '/files/download/';
        file_put_contents($localDownloadDirectory . 'file1', $downloadedTextFile);

        $imageFileName = 'image1.jpg';
        $uploadedImageFile = $api->uploadFile($level1Folder4Path, $imageFileName,
            $localUploadDirectory . 'image.jpg', Exists::OVERWRITE);
        $this->assertNotNull($uploadedImageFile);
        $this->assertEquals($imageFileName, $uploadedImageFile['result']['name']);
        $uploadedImageFilePath = $this->getPath($uploadedImageFile['result'], $level1Folder4Path);

        $downloadedImageFile = $api->downloadFile($uploadedImageFilePath);
        $this->assertNotEmpty($downloadedImageFile);
        file_put_contents($localDownloadDirectory . 'image1.jpg', $downloadedImageFile);

        $newName = 'Moved' . $uploadedImageFile['result']['name'];
        $movedFile = $api->moveFile($uploadedImageFilePath, $level1Folder3Path, $newName, Exists::OVERWRITE);
        $this->assertNotNull($movedFile);
        $this->assertEquals($newName, $movedFile['result']['meta']['name']);
        $newPath = $this->getPath($movedFile['result']['meta'], $level1Folder3Path);

        $copiedFile = $api->copyFile($newPath, $level1Folder4Path, $imageFileName, Exists::OVERWRITE);
        $this->assertNotNull($copiedFile);
        $this->assertEquals($imageFileName, $copiedFile['result']['meta']['name']);

        $deletedFile = $api->deleteFile($newPath);
        $this->assertTrue($deletedFile['result']['success']);

        $this->assertNotNull($this->getItem($api->getList($level1Folder3Path), $textFileName));
        $this->assertNotNull($this->getItem($api->getList($level1Folder4Path), $imageFileName));
    }

//    public function testHistory() {
//        $api = $this->getSession()->getBitcasaClientApi();
//        $level0Folder1 = $this->getItem($api->getList(), $this->level0Folder1Name);
//        $level0Folder1Path = $this->getPath($level0Folder1);
//
//        $level1Folder5 = $api->createFolder($level0Folder1Path, $this->level1Folder5Name, Exists::OVERWRITE);
//        $this->assertNotNull($level1Folder5);
//        $this->assertEquals($this->level1Folder5Name, $level1Folder5['name']);
//        $level1Folder5Path = $this->getPath($level1Folder5, $level0Folder1Path);
//
//        $localUploadDirectory = dirname(__FILE__) . '/files/upload/';
//        $fileName = 'history';
//        $uploadedFile = $api->uploadFile($level1Folder5Path, $fileName,
//            $localUploadDirectory . 'history1');
//
//        $uploadedFile = $api->uploadFile($level1Folder5Path, $fileName,
//            $localUploadDirectory . 'history2');
//
//        $uploadedFile = $api->uploadFile($level1Folder5Path, $fileName,
//            $localUploadDirectory . 'history3');
//
//        $uploadedFilePath = $this->getPath($uploadedFile['result'], $level1Folder5Path);
//
//        $history = $api->fileHistory($uploadedFilePath);
//        $test = '';
//    }

}