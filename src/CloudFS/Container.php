<?php

namespace CloudFS;

use CloudFS\Utils\BitcasaConstants;

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
     * @param array $parentState The parent state.
     */
    protected function __construct($data, $parentPath, $restAdapter, $parentState) {
        parent::__construct($data, $parentPath, $restAdapter, $parentState);
    }

    /**
     * Retrieves the item list at this items path.
     *
     * @return The item list array.
     */
    public function getList() {
        $parentState = $this->getParentState();
        if (empty($parentState)) {
            return $this->restAdapter()->getList($this->getPath());
        }
        else{
            if (array_key_exists(BitcasaConstants::KEY_SHARE_KEY, $parentState)) {
                return $this->restAdapter()->browseShare($parentState[BitcasaConstants::KEY_SHARE_KEY], $this->getPath());
            }
            else if(array_key_exists(BitcasaConstants::KEY_IN_TRASH, $parentState)) {
                return $this->restAdapter()->listTrash($this->getPath());
            }
        }

        return null;
    }

}