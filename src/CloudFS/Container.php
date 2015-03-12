<?php

namespace CloudFS;

/**
 * Class Container
 * Handles the Container item type operations.
 * @package CloudFS
 */
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