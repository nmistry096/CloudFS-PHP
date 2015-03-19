<?php

namespace CloudFS;

use CloudFS\Utils\Exists;

class Folder extends Container {

    /**
     * Initializes a new instance of Folder.
     *
     * @param array $data The item data.
     * @param string $parentPath The item parent path.
     * @param \CloudFS\RESTAdapter $restAdapter The rest adapter instance.
     */
    protected function __construct($data, $parentPath, $restAdapter) {
        parent::__construct($data, $parentPath, $restAdapter);
    }

    /**
     * Creates a folder item under this item with the supplied name.
     *
     * @param string $name The name of the folder being created.
     * @param string $exists The action to take if the folder already exists.
     * @return Instance of the newly created folder.
     */
    public function createFolder($name, $exists = Exists::OVERWRITE) {
        return $this->restAdapter()->createFolder($this->getPath(), $name, $exists);
    }

    /**
     * Uploads a file to the folder.
     *
     * @param string $filesystemPath The path of the local file upload.
     * @param mixed $uploadProgressCallback The upload progress callback function. This function should take
     * 'downloadSize', 'downloadedSize', 'uploadSize', 'uploadedSize' as arguments.
     * @param string $exists The action to take if the file already exists.
     .
     * @return A file instance representing the uploaded file..
     */
    public function upload($filesystemPath, $uploadProgressCallback, $exists = Exists::FAIL) {
        return $this->restAdapter()->uploadFile($this->getPath(), null, $filesystemPath, $exists, $uploadProgressCallback);
    }
}