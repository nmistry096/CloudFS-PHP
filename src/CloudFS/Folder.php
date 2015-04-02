<?php

namespace CloudFS;

use CloudFS\Utils\Assert;
use CloudFS\Utils\Exists;

class Folder extends Container {

    /**
     * Initializes a new instance of Folder.
     *
     * @param array $data The item data.
     * @param string $parentPath The item parent path.
     * @param \CloudFS\RESTAdapter $restAdapter The rest adapter instance.
     * @param array $parentState The parent state.
     */
    protected function __construct($data, $parentPath, $restAdapter, $parentState) {
        parent::__construct($data, $parentPath, $restAdapter, $parentState);
    }

    /**
     * Creates a folder with the specified name.
     *
     * @param string $name The name of the folder being created.
     * @param string $exists The action to take if the folder already exists.
     * @return A folder instance.
     */
    public function createFolder($name, $exists = Exists::OVERWRITE) {
        Assert::assertStringOrEmpty($name. 1);
        $item = null;
        $response = $this->restAdapter()->createFolder($this->getPath(), $name, $exists);
        if ($response != null && isset($response['result']) && isset($response['result']['items'])) {
            $item = Item::make($response['result']['items'][0], $this->getPath(), $this->restAdapter(),
                $this->getParentState());
        }

        return $item;
    }

    /**
     * Uploads the specified file to the folder.
     *
     * @param string $filesystemPath The path of the local file to be uploaded.
     * @param mixed $uploadProgressCallback The upload progress callback function. This function should take
     * 'downloadSize', 'downloadedSize', 'uploadSize', 'uploadedSize' as arguments.
     * @param string $exists The action to take if the file already exists.
     * .
     * @return A file instance.
     */
    public function upload($filesystemPath, $uploadProgressCallback, $exists = Exists::FAIL) {
        Assert::assertStringOrEmpty($filesystemPath, 1);
        $filename = basename($filesystemPath);
        $response = $this->restAdapter()->uploadFile($this->getPath(), $filename, $filesystemPath, $exists,
            $uploadProgressCallback);
        return Item::make($response['result'], $this->getPath(), $this->restAdapter(), $this->getParentState());
    }
}