<?php
/**
 * Created by PhpStorm.
 * User: dhanushka
 * Date: 3/10/15
 * Time: 1:32 PM
 */

namespace CloudFS;


class Photo extends File {

    /**
     * Initializes a new instance of Photo.
     *
     * @param BitcasaApi $api The api instance.
     */
    public function __construct($api = null) {
        parent::__construct($api);
    }

}