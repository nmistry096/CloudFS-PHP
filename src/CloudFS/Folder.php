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

}