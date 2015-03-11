<?php
/**
 * Created by PhpStorm.
 * User: dhanushka
 * Date: 3/10/15
 * Time: 1:29 PM
 */

namespace CloudFS;


class Folder extends Container {

    /**
     * Initializes a new instance of Folder.
     *
     * @param BitcasaApi $api The api instance.
     */
    public function __construct($api = null) {
        parent::__construct($api);
    }

    /**
     * Creates a folder item under this item with the supplied name.
     *
     * @param string $name The name of the folder being created.
     * @param string $exists The action to take if the folder already exists.
     * @return Instance of the newly created folder.
     */
    public function createFolder($name, $exists="overwrite") {
        return $this->api()->create($this, $name, $exists);
    }

    /**
     * Uploads a file under this item.
     *
     * @param string $path The path of the file to be uploaded.
     * @param string $name The name of the file.
     * @param string $exists The action to take if the file already exists.
     * @return An instance of the uploaded item.
     */
    public function upload($path, $name = null, $exists='fail') {
        return $this->api()->upload($this, $path, $name, $exists);
    }
}