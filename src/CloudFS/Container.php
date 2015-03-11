<?php
/**
 * Created by PhpStorm.
 * User: dhanushka
 * Date: 3/10/15
 * Time: 1:29 PM
 */

namespace CloudFS;


class Container extends Item {

    /**
     * Initializes a new instance of Container.
     *
     * @param BitcasaApi $api The api instance.
     */
    public function __construct($api = null) {
        parent::__construct($api);
    }

    /**
     * Retrieves the item list at this items path.
     *
     * @return The item list array.
     */
    public function getList() {
        return $this->api()->getList($this->getPath());
    }

}