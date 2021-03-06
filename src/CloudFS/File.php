<?php

namespace CloudFS;


use CloudFS\Utils\Assert;

class File extends Item {

    private $extension;
    private $mime;
    private $size;

    /**
     * Initializes a new instance of File.
     *
     * @param array $data The item data.
     * @param string $parentPath The item parent path.
     * @param \CloudFS\RESTAdapter $restAdapter The rest adapter instance.
     * @param array $parentState The parent state.
     */
    protected function __construct($data, $parentPath, $restAdapter, $parentState) {
        parent::__construct($data, $parentPath, $restAdapter, $parentState);
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
     * Sets the Mime type of this item and updates to CloudFS.
     *
     * @param string $newMime The new Mime type of the item.
     */
    public function setMime($newMime) {
        Assert::assertStringOrEmpty($newMime, 1);
        $this->mime = $newMime;
        $this->changeAttributes(array('mime' => $newMime, 'version' => $this->getVersion()));
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
     * Downloads the file from the cloud to the specified local path.
     *
     * @param string $localDestinationPath The local path of the file to download the content.
     * @param mixed $downloadProgressCallback The download progress callback function. This function should take
     * 'downloadSize', 'downloadedSize', 'uploadSize', 'uploadedSize' as arguments.
     * @return The success/fail status of the download operation.
     */
    public function download($localDestinationPath, $downloadProgressCallback) {
        Assert::assertStringOrEmpty($localDestinationPath, 1);
        return $this->restAdapter()->downloadFile($this->getPath(), $localDestinationPath, $downloadProgressCallback);
    }

    /**
     * Returns the metadata for selected versions of a file as
     * recorded in the History after successful metadata changes.
     * @param int $startVersion The version from which the version retrieval should start.
     * @param int $endVersion Up to which version the version retrieval should be done.
     * @param int $limit The number of versions to be retrieved limit.
     * @return The versions list.
     */
    public function versions($startVersion = 0, $endVersion = null, $limit = 10) {
        $versions = $this->restAdapter()->fileVersions($this->getPath(), $startVersion, $endVersion, $limit);
        return $versions;
    }

    /**
     * Read the file stream.
     * @return The file stream.
     */
    public function read() {
        return $this->restAdapter()->fileRead($this->getPath());
    }

    /**
     * Gets the download url for the file.
     * @return The download url.
     */
    public function downloadUrl() {
        return $this->restAdapter()->downloadUrl($this->getPath());
    }

}
