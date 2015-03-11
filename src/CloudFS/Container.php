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
     * @param Filesystem $filesystem The Filesystem instance.
     */
    public function __construct($filesystem = null) {
        parent::__construct($filesystem);
    }

    /**
     * Retrieves the item list at this items path.
     *
     * @return The item list array.
     */
    public function getList() {
        return $this->filesystem()->getList($this->getPath());
    }

}