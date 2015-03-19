<?php

namespace CloudFS;


class ShareFolder extends Folder {

    /**
     * Initializes a new instance of shared folder.
     *
     * @param array $data The item data.
     * @param string $parentPath The item parent path.
     * @param \CloudFS\RESTAdapter $restAdapter The rest adapter instance.
     */
    protected function __construct($data, $parentPath, $restAdapter) {
        parent::__construct($data, $parentPath, $restAdapter);
    }

}