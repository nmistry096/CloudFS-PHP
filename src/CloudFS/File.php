<?php

namespace CloudFS;


class File extends Item {

    /**
     * Initializes a new instance of File.
     *
     * @param BitcasaApi $api The api instance.
     */
    public function __construct($api = null) {
        parent::__construct($api);
    }

    /**
     * Downloads this file from the cloud.
     *
     * @param string $localPath The local path where the file is to be downloaded to.
     */
    public function download($localPath) {
        $content = $this->api()->download($this, $localPath);
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

}