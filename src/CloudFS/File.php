<?php

namespace CloudFS;


class File extends Item {

    /**
     * Initializes a new instance of File.
     *
     * @param Filesystem $filesystem The Filesystem instance.
     */
    public function __construct($filesystem = null) {
        parent::__construct($filesystem);
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
     * Retrieves the extension of this item.
     *
     * @return The extension of this item.
     */
    public function getExtension() {
        return $this->data['extension'];
    }

    /**
     * Retrieves the mime type of this item.
     *
     * @return The mime type of this item.
     */
    public function getMime() {
        return $this->data['mime'];
    }

    /**
     * Sets the Mime type of this item.
     *
     * @param string $newMime The new Mime type of the item.
     */
    public function setMime($newMime) {
        $this->change('mime');
        $this->data['mime'] = $newMime;
    }

    /**
     * Retrieves the size of this item.
     *
     * @return The size of this item.
     */
    public function getSize() {
        return $this->data['size'];
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

    public function read(){
        return $this->filesystem()->fileRead($this);
    }

    public function downloadUrl(){
        
    }



}