<?php

namespace CloudFS;

use CloudFS\Utils\BitcasaConstants;
use CloudFS\Utils\FileType;

class Item {

    private $parent;
    private $full_path;
    private $data;
    private $api;
    private $change_list;

    /**
     * Initializes the item instance.
     *
     * @param BitcasaApi $api The api instance.
     */
    public function __construct($api = null) {
        $this->data = NULL;
        $this->parent = Null;
        $this->full_path = Null;
        $this->data = array();
        $this->api = $api;
        $this->changes = array();
    }

    /**
     * Retrieves this api instance.
     *
     * @return The api instance.
     */
    public function api() {
        return $this->api;
    }

    /**
     * Adds the passed change key to this items change list.
     *
     * @param string $key The supplied change key.
     */
    public function change($key) {
        $this->change_list[] = $key;
    }

    /**
     * Retrieves this items changes.
     *
     * @param bool $add_version Flag to add version to result or not.
     * @return An array of this items changes.
     */
    public function changes($add_version = false) {
        $res = array();
        foreach ($this->change_list as $key) {
            $res[$key] = $this->data[$key];
        }
        if ($add_version) {
            $res['version'] = $this->data['version'];
        }
        return $res;
    }

    /**
     * Returns an array of path components given a path.
     *
     * @param string $pathString Path of an item.
     * @return An array of path components.
     */
    public static function componentsFromPath($pathString) {
        $paths = explode("/", rtrim($pathString, "/"));
        if ($paths[0] == '') {
            $path[0] = "/";
        }
        return $paths;
    }

    /**
     * Retrieves the path given an item list.
     *
     * @param Item[] $items The items whose path needs to be retrieved.
     * @param bool $addRoot Flag to add root to the retrieved path or not.
     * @return Path of the item list.
     */
    public static function pathFromItemList($items, $addRoot=False) {
        $first = true;
        $path = "";
        foreach ($items as $item) {
            if ($first) {
                $first = false;
                $path .= $addRoot ? "/" : "";
            } else {
                $path .= "/";
            }
            $path .= $item->getId();
        }
        return $path;
    }

    /**
     * Formats and returns the path of an item given an array of paths.
     *
     * @param array $components The array containing path elements.
     * @param bool $addRoot Flag to add root to the retrieved path or not.
     * @return Formatted path for the given array.
     */
    public static function pathFromComponents($components, $addRoot=False) {
        $path = implode("/", $components);
        if ($addRoot) {
            $path = "/" . $path;
        }
        return $path;
    }

    /**
     * Retrieves the path for a given item.
     *
     * @param Item $item The item whose path needs to be retrieved.
     * @return The path of the item.
     */
    public function pathFromItem($item = null) {
        if ($item == null) {
            $item = $this;
        }

        $path = array();
        while ($item != null) {
            array_unshift($path, $item);
            $item = $item->parent;
        }
        return pathFromComponents($path);
    }

    /**
     * Retrieves an instance of an item for the supplied data.
     *
     * @param object $data The data needed to create an item.
     * @param string $parentPath Parent path for the new item.
     * @param Filesystem $api The file system instance.
     * @return An instance of the new item.
     */
    public static function make($data, $parentPath = null, $api = null) {
        $item = null;
        if (count($data) == 0) {
            return null;
        }
        if (!isset($data['id']) || !isset($data['type'])) {
            return null;
        }

        if ($data["type"] == FileType::FOLDER) {
            $item = new Folder($api);
        } else if (isset($data['mime'])) {
            $t = explode("/", $data['mime']);
            switch ($t[0]) {
                case 'image':
                    $item = new Photo($api);
                    break;

                case 'audio':
                    $item = new Audio($api);
                    break;

                case 'video':
                    $item = new Video($api);
                    break;

                case 'text':
                    $item = new Document($api);
                    break;

                case 'application':
                    if ($t[1] == 'pdf') {
                        $item = new Document($api);
                        break;
                    }

                default:
                    $item = new File($api);
                    break;
            }
        } else if($data["type"] == FileType::FILE) {
            $item = new File($api);
        } else {
            $item = new Container($api);
        }

        $item->data = $data;

        if ($parentPath == null) {
            $item->full_path = "/" . $item->data['id'];
        }
        else if ($parentPath == '/') {
            $item->full_path = $parentPath . $item->data['id'];
        }
        else {
            $item->full_path = $parentPath . '/' . $item->data['id'];
        }

        return $item;
    }

    /**
     * Retrieves the data value of a given key.
     *
     * @param string $key The key for whose data value should be retrieved.
     * @param string $default The value to be returned if the data value does not exist.
     * @return The data value for the given key.
     */
    protected function value($key, $default = null) {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        } else {
            return $default;
        }
    }

    /**
     * Retrieves the name of this item.
     *
     * @return The name of the item.
     */
    public function getName() {
        return $this->data['name'];
    }

    /**
     * Sets the name of this item.
     *
     * @param string $newName The name of the item.
     */
    public function setName($newName) {
        $this->change('name');
        $this->data['name'] = $newName;
    }

    /**
     * Retrieves the id of this item.
     *
     * @return The data id of the item.
     */
    public function getId() {
        return $this->data['id'];
    }

    /**
     * Sets the id of this item - Not Allowed.
     *
     * @param string $newId The new id to be set on the item.
     * @throws OperationNotAllowed
     */
    public function setId($newId) {
        throw new OperationNotAllowed("Setting the id of an Item");
    }

    /**
     * Retrieves the parent id of this item.
     *
     * @return The parent id of this item.
     */
    public function getParentId() {
        return $this->data['parent_id'];
    }

    /**
     * Retrieves the type of this item.
     *
     * @return The type of this item.
     */
    public function getType() {
        return $this->data['type'];
    }

    /**
     * Set the type of this item - Not Allowed.
     *
     * @param string $newType The new type to be set on the item.
     * @throws OperationNotAllowed
     */
    public function setType($newType) {
        throw new OperationNotAllowed("Setting the type of an Item");
    }

    /**
     * Retrieves the is mirrored flag of this item.
     *
     * @return Is mirrored flag of this item.
     */
    public function getIsMirrored() {
        return $this->data['is_mirrored'];
    }

    /**
     * Sets the is mirrored flag of this item - Not Allowed.
     *
     * @param string $newMirroredFlag The new mirrored flag to be set on the item.
     * @throws OperationNotAllowed
     */
    public function setMirrored($newMirroredFlag) {
        throw new OperationNotAllowed("Setting if an Item is mirrored");
    }

    /**
     * Retrieve the content last modified date of this item.
     *
     * @return The content last modified date.
     */
    public function getDateContentLastModified() {
        return $this->data['date_content_last_modified'];
    }

    /**
     * Sets the content last modified date of this item.
     *
     * @param string $newDateContentLastModified The new content last modified date.
     */
    public function setDateContentLastModified($newDateContentLastModified) {
        $this->change('date_content_last_modified');
        $this->data['date_content_last_modified'] = $newDateContentLastModified;
    }

    /**
     * Retrieves the created date of this item.
     *
     * @return The created date of this item.
     */
    public function getDateCreated() {
        return $this->data['date_created'];
    }

    /**
     * Sets the created date of this item.
     *
     * @param string $newDateCreated The new created date.
     */
    public function setDateCreated($newDateCreated) {
        $this->change('date_created');
        $this->data['date_created'] = $newDateCreated;
    }

    /**
     * Retrieves the version of this item.
     *
     * @return The version of this item.
     */
    public function version() {
        return $this->data['version'];
    }

    /**
     * Sets the version of this item.
     *
     * @param string $newVersion The new version.
     */
    public function setVersion($newVersion) {
        $this->change('version');
        $this->data['version'] = $newVersion;
    }

    /**
     * Retrieve the parent path id of this item.
     *
     * @return The parent path id of this item.
     */
    public function getParentPath() {
        return $this->data['absolute_parent_path_id'];
    }

    /**
     * Sets the parent path id of this item.
     *
     * @param string $newAbsoluteParentPathId The new parent path id.
     */
    public function setParentPath($newAbsoluteParentPathId) {
        $this->change('absolute_parent_path_id');
        $this->data['absolute_parent_path_id'] = $newAbsoluteParentPathId;
    }

    /**
     * Retrieves the meta last modified date of this item.
     *
     * @return The meta last modified date of this item.
     */
    public function getDateMetaLastModified() {
        return $this->data['date_meta_last_modified'];
    }

    /**
     * Sets the meta last modified date of this item.
     *
     * @param string $newDateMetaLastModified The new meta last modified date.
     */
    public function setDateMetaLastModified($newDateMetaLastModified) {
        $this->change('date_meta_last_modified');
        $this->data['date_meta_last_modified'] = $newDateMetaLastModified;
    }

    /**
     * Retrieves the application data of this item.
     *
     * @return The application data of this item.
     */
    public function getApplicationData() {
        return $this->data['application_data'];
    }

    /**
     * Sets the new application data of this item.
     *
     * @param mixed $newApplicationData The new application data.
     */
    public function setApplicationData($newApplicationData) {
        $this->change('application_data');
        $this->data['application_data'] = $newApplicationData;
    }

    /**
     * Retrieves the url of this item.
     *
     * @return The full path of this item.
     */
    public function url() {
        return $this->full_path;
    }

    /**
     * Retrieves the url of this item.
     *
     * @return The full path of this item.
     */
    public function getPath() {
        return $this->full_path;
    }

    /**
     * Moves this item to a given destination.
     *
     * @param string $destination The destination of the item move.
     * @param string $exists The action to take if the item exists.
     * @return The success/fail response of the move operation.
     */
    public function move($destination, $exists = BitcasaConstants::EXISTS_RENAME) {
        return $this->api()->move($this, $destination, $exists);
    }

    /**
     * Copy this item to a given destination.
     *
     * @param string $destination The destination of the item copy.
     * @param string $exists The action to take if the item exists.
     * @return The success/fail response of the copy operation.
     */
    public function copy($destination, $exists = BitcasaConstants::EXISTS_RENAME) {
        return $this->api()->copy($this, $destination, $exists);
    }

    /**
     * Delete this item from the cloud.
     *
     * @param bool $commit Flag to commit the delete operation.
     * @param bool $force Flag to force the delete operation.
     * @return The success/fail response of the delete operation.
     */
    public function delete($commit=False, $force=False) {
        return $this->api()->delete($this, $force);
    }

    /**
     * Save this item on the cloud.
     *
     * @param string $ifConflict The action to take if a conflict occurs.
     * @param bool $debug Debug flag.
     * @return The success/fail response of the save operation.
     */
    public function save($ifConflict="fail", $debug=False) {
        return $this->api()->save($this);
    }

    /**
     * Restores this item to the given destination.
     *
     * @param string $destination The destination of the item restore.
     * @return The success/fail response of the restore operation.
     */
    public function restore($destination) {
        if (!is_string($destination)) {
            $destination = $destination->path();
        }
        return $this->api()->restore($this, $destination);
    }

    /**
     * Retrieves the files history of this file.
     *
     * @return The file history response.
     */
    public function history() {
        return $this->api()->fileHistory($this);
    }
}