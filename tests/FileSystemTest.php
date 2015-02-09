<?php

require __DIR__ . '/../vendor/autoload.php';

class FileSystemTest extends BaseTest {

    private $rootFolderName = 'root-test';
    private $subFolder1Name = 'sub-folder-1';
    private $subFolder2Name = 'sub-folder-2';
    private $subSubFolderName = 'sub-sub-folder';

    public function testAuthenticate(){
        $this->getSession()->authenticate(self::USERNAME, self::PASSWORD);
        $this->assertTrue(true, $this->getSession()->isLinked());
    }

    public function testCreateRootFolder() {
        $folder = $this->getSession()->getBitcasaClientApi()->createFolder(NULL, $this->rootFolderName, Exists::OVERWRITE);
        $this->assertNotNull($folder);
        $this->assertArrayHasKey("name", $folder);
        $this->assertTrue($folder['name'] == $this->rootFolderName);
        $this->assertTrue($folder['type'] == FileType::FOLDER);
        $this->assertNotEmpty($folder['id']);
        $this->assertEmpty($folder['parent_id']);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionCode 409
     */
    public function testCreateRootFolderFailIfExists() {
        $this->getSession()->getBitcasaClientApi()->createFolder(NULL, $this->rootFolderName, Exists::FAIL);
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
            if ($item['name'] == $this->rootFolderName) {
                $folderFound = true;
                break;
            }
        }

        $this->assertTrue($folderFound);
    }

    public function testCreateSubFolders() {
        $fileSystem = new Filesystem($this->getSession()->getBitcasaClientApi());
        $root = $fileSystem->getFolder(null);
        $this->assertNotNull($root);
        $this->assertEquals(FileType::ROOT, $root->type());

        $topLevelFolder = $root->create($this->rootFolderName);
        $this->assertNotNull($topLevelFolder);
        $this->assertNotEmpty($topLevelFolder->path());
        $topLevelFolderPath = $topLevelFolder->path();
        $this->assertEquals($this->rootFolderName, $topLevelFolder->name());

        $subFolder1 = $topLevelFolder->create($this->subFolder1Name);
        $this->assertEquals($this->subFolder1Name, $subFolder1->name());
        $this->assertNotEmpty($subFolder1->path());

        $subFolder2 = $topLevelFolder->create($this->subFolder2Name);
        $this->assertNotEmpty($subFolder2->path());
        $subFolder2Path = $subFolder2->path();

        $subSubFolder = $subFolder2->create($this->subSubFolderName);
        $this->assertNotEmpty($subSubFolder->path());

        $folder = $fileSystem->getFolder($subFolder2Path);
        $this->assertNotNull($folder);
        $this->assertEquals($this->subFolder2Name, $folder->name());

        $items = $folder->get_list();
        $this->assertTrue(count($items) > 0);
        $this->assertEquals($this->subSubFolderName, $items[0]->name());
    }

}