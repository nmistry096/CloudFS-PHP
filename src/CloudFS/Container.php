<?php

namespace CloudFS;


class Container extends Item {

    /**
     * Initializes a new instance of Container.
     *
     * @param array $data The item data.
     * @param string $parentPath The item parent path.
     * @param \CloudFS\Filesystem $filesystem The file system instance.
     */
    protected function __construct($data, $parentPath, $filesystem) {
        parent::__construct($data, $parentPath, $filesystem);
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