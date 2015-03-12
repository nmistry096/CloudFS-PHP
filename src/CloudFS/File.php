<?php

namespace CloudFS;

use CloudFS\Utils\VersionExists;


class File extends Item {

    private $extension;
    private $mime;
    private $size;

    /**
     * Initializes a new instance of File.
     *
     * @param array $data The item data.
     * @param string $parentPath The item parent path.
     * @param \CloudFS\Filesystem $filesystem The file system instance.
     */
    protected function __construct($data, $parentPath, $filesystem) {
        parent::__construct($data, $parentPath, $filesystem);
        $this->mime = $data['mime'];
        $this->extension = $data['extension'];
        $this->size = $data['size'];
    }

    /**
     * Retrieves the extension of this item.
     *
     * @return The extension of this item.
     */
    public function getExtension() {
        return $this->extension;
    }

    /**
     * Retrieves the mime type of this item.
     *
     * @return The mime type of this item.
     */
    public function getMime() {
        return $this->mime;
    }

    /**
     * Sets the Mime type of this item.
     *
     * @param string $newMime The new Mime type of the item.
     */
    public function setMime($newMime) {
        $this->mime = $newMime;
    }

    /**
     * Retrieves the size of this item.
     *
     * @return The size of this item.
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * Alters the specified attributes.
     *
     * @param array $values The values that need to be changed.
     * @param int $ifConflict Defines what to do when a conflict occurs.
     * @return The status of the operation.
     */
    public function changeAttributes(array $values, $ifConflict = VersionExists::FAIL) {
        $success = false;
        $result = $this->filesystem()->alterFile($this->getPath(), $values, $ifConflict);
        if (empty($result['error'])) {
            $success = true;
        }

        return $success;
    }

    /**
     * Downloads this file from the cloud.
     *
     * @param string $localPath The local path where the file is to be downloaded to.
     */
    public function download($localPath) {
        $content = $this->filesystem()->download($this, $localPath);
        file_put_contents($localPath, $content);
    }

    /**
     * Returns the metadata for selected versions of a file as
     * recorded in the History after successful metadata changes.
     * @param int $startVersion
     * @param null $endVersion
     * @param int $limit
     * @return mixed
     */
    public function versions($startVersion = 0, $endVersion = null, $limit = 10){
        $versions = $this->filesystem()->fileVersions($this, $startVersion, $endVersion, $limit);
        return $versions;
    }


}