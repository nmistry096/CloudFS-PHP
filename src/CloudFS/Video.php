<?php
/**
 * Created by PhpStorm.
 * User: dhanushka
 * Date: 3/10/15
 * Time: 1:31 PM
 */

namespace CloudFS;


class Video extends File {

    /**
     * Initializes a new instance of Video.
     *
     * @param BitcasaApi $api The api instance.
     */
    public function __construct($api = null) {
        parent::__construct($api);
    }

}