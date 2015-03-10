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
        $this->api()->downloadFile($this, $localPath);
    }

}