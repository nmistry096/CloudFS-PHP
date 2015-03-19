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
     * @param array $data The item data.
     * @param string $parentPath The item parent path.
     * @param \CloudFS\RESTAdapter $restAdapter The rest adapter instance.
     */
    protected function __construct($data, $parentPath, $restAdapter) {
        parent::__construct($data, $parentPath, $restAdapter);
    }

    /**
     * Retrieves the item list at this items path.
     *
     * @return The item list array.
     */
    public function getList() {
        return $this->restAdapter()->getList($this->getPath());
    }

}