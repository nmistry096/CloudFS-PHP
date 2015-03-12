<?php

namespace CloudFS;


class Audio extends File {

    /**
     * Initializes a new instance of Audio.
     *
     * @param BitcasaApi $api The api instance.
     */
    public function __construct($api = null) {
        parent::__construct($api);
    }

}