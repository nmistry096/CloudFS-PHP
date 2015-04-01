<?php

namespace CloudFS;

use CloudFS\Utils\BitcasaConstants;
use CloudFS\Utils\FileType;
use CloudFS\Utils\VersionExists;
use CloudFS\Utils\RestoreMethod;

class Item {

    private $fullPath;
    private $restAdapter;
    private $id;
    private $type;
    private $isMirrored;
    private $dateContentLastModified;
    private $dateCreated;
    private $dateMetaLastModified;
    private $name;
    private $applicationData;
    private $version;
    private $parentState;

    /**
     * Initializes an item instance.
     *
     * @param array $data The item data.
     * @param string $parentPath The item parent path.
     * @param \CloudFS\RESTAdapter $restAdapter The rest adapter instance.
     * @param array $parentState The parent state of the item.
     */
    protected function __construct($data, $parentPath, $restAdapter, $parentState) {
        $this->restAdapter = $restAdapter;

        $this->id = $data['id'];
        $this->type = $data['type'];
        $this->name = $data['name'];
        $this->dateContentLastModified = $data['date_content_last_modified'];
        $this->dateCreated = $data['date_created'];
        $this->dateMetaLastModified = $data['date_meta_last_modified'];
        $this->applicationData = $data['application_data'];
        $this->isMirrored = $data['is_mirrored'];
        $this->version = $data['version'];
        $this->parentState = $parentState;

        if ($parentPath == null) {
            $this->fullPath = "/" . $this->id;
        } else if ($parentPath == '/') {
            $this->fullPath = $parentPath . $this->id;
        } else {
            $this->fullPath = $parentPath . '/' . $this->id;
        }
    }

    /**
     * Retrieves the item name.
     *
     * @return The item name.
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Sets the item name.
     *
     * @param string $newName The item name.
     */
    public function setName($newName) {
        $this->name = $newName;
        $this->changeAttributes(array('name' => $newName, 'version' => $this->getVersion()));
    }

    /**
     * Gets the item id.
     *
     * @return The data id of the item.
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Retrieves the type of this item.
     *
     * @return The type of this item.
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Retrieve the content last modified date of this item.
     *
     * @return The content last modified date.
     */
    public function getDateContentLastModified() {
        return $this->dateContentLastModified;
    }

    /**
     * Retrieves the created date of this item.
     *
     * @return The created date of this item.
     */
    public function getDateCreated() {
        return $this->dateCreated;
    }

    /**
     * Retrieves the meta last modified date of this item.
     *
     * @return The meta last modified date of this item.
     */
    public function getDateMetaLastModified() {
        return $this->dateMetaLastModified;
    }

    /**
     * Retrieves the application data of this item.
     *
     * @return The application data of this item.
     */
    public function getApplicationData() {
        return $this->applicationData;
    }

    /**
     * Sets the item application data.
     *
     * @param array $newApplicationData The application data.
     */
    public function setApplicationData(array $newApplicationData) {
        $this->applicationData = $newApplicationData;
        $this->changeAttributes(array('application_data' => $newApplicationData, 'version' => $this->getVersion()));
    }

    /**
     * Retrieves the url of this item.
     *
     * @return The full path of this item.
     */
    public function getPath() {
        return $this->fullPath;
    }

    /**
     * Retrieves the is mirrored flag of this item.
     *
     * @return Is mirrored flag of this item.
     */
    public function getIsMirrored() {
        return $this->isMirrored;
    }

    /**
     * Gets the parent state of the item.
     *
     * @return The parent state.
     */
    public function getParentState() {
        return $this->parentState;
    }

    /**
     * Gets the item version number.
     *
     * @return The item version number.
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * Retrieves this rest adapter instance.
     *
     * @return \CloudFS\RESTAdapter The rest adapter instance.
     */
    public function restAdapter() {
        return $this->restAdapter;
    }

    /**
     * Retrieves an instance of an item for the supplied data.
     *
     * @param array $data The data needed to create an item.
     * @param string $parentPath Parent path for the new item.
     * @param \CloudFS\RESTAdapter $restAdapter The rest adapter instance.
     * @param array $parentState The parent state.
     * @return An instance of the new item.
     */
    public static function make($data, $parentPath = null, $restAdapter = null, $parentState = null) {
        $item = null;
        if (count($data) == 0) {
            return null;
        }
        if (!isset($data['id']) || !isset($data['type'])) {
            return null;
        }


        if ($data["type"] == FileType::FOLDER || $data['type'] == FileType::ROOT) {
            $item = new Folder($data, $parentPath, $restAdapter);
        } else if (isset($data['mime'])) {
            $t = explode("/", $data['mime']);
            switch ($t[0]) {
                case 'image':
                    $item = new Photo($data, $parentPath, $restAdapter);
                    break;

                case 'audio':
                    $item = new Audio($data, $parentPath, $restAdapter);
                    break;

                case 'video':
                    $item = new Video($data, $parentPath, $restAdapter);
                    break;

                case 'text':
                    $item = new Document($data, $parentPath, $restAdapter);
                    break;

                case 'application':
                    if ($t[1] == 'pdf') {
                        $item = new Document($data, $parentPath, $restAdapter);
                        break;
                    }

                default:
                    $item = new File($data, $parentPath, $restAdapter);
                    break;
            }
        } else if ($data["type"] == FileType::FILE) {
            $item = new File($data, $parentPath, $restAdapter);
        } else {
            $item = new Container($data, $parentPath, $restAdapter);
        }

        return $item;
    }

    /**
     * Alters the specified attributes.
     *
     * @param array $values The values that need to be changed.
     * @param int $ifConflict Defines what to do when a conflict occurs.
     * @return The status of the operation.
     */
    public function changeAttributes(array $values, $ifConflict = VersionExists::FAIL) {
        $success = false;
        $values['version'] = $this->getVersion();
        if ($this->getType() == FileType::FILE) {
            $result = $this->restAdapter()->alterFileMeta($this->getPath(), $values, $ifConflict);
        } else {
            $result = $this->restAdapter()->alterFolderMeta($this->getPath(), $values, $ifConflict);
        }

        if (empty($result['error'])) {
            $success = true;
        }

        return $success;
    }

    /**
     * Moves this item to a given destination.
     *
     * @param string $destination The destination of the item move.
     * @param string $exists The action to take if the item exists.
     * @return The moved item instance.
     */
    public function move($destination, $exists = BitcasaConstants::EXISTS_RENAME) {
        $item = null;
        if ($this->getType() == FileType::FILE) {
            $response = $this->restAdapter()->moveFile($this->getPath(), $destination, $this->getName(), $exists);
        } else {
            $response = $this->restAdapter()->moveFolder($this->getPath(), $destination, $this->getName(), $exists);
        }

        if ($response != null && isset($response['result']) && isset($response['result']['meta'])) {
            $item = Item::make($response['result']['meta'], $destination, $this->restAdapter(), $this->parentState);
        }

        return $item;
    }

    /**
     * Copy this item to a given destination.
     *
     * @param string $destination The destination of the item copy.
     * @param string $exists The action to take if the item exists.
     * @return The success/fail response of the copy operation.
     */
    public function copy($destination, $exists = BitcasaConstants::EXISTS_RENAME) {
        $item = null;
        if ($this->getType() == FileType::FILE) {
            $response = $this->restAdapter()->copyFile($this->getPath(), $destination, $this->getName(), $exists);
        } else {
            $response = $this->restAdapter()->copyFolder($this->getPath(), $destination, $this->getName(), $exists);
        }

        if ($response != null && isset($response['result']) && isset($response['result']['meta'])) {
            $item = Item::make($response['result']['meta'], $destination, $this->restAdapter(), $this->parentState);
        }

        return $item;
    }

    /**
     * Delete this item from the cloud.
     *
     * @param bool $commit Flag to commit the delete operation.
     * @param bool $force Flag to force the delete operation.
     * @return Boolean value indicating the status of the delete operation.
     */
    public function delete($commit = False, $force = False) {
        if ($this->getType() == FileType::FILE) {
            $success = $this->restAdapter()->deleteFile($this->getPath(), $force);
        } else {
            $success = $this->restAdapter()->deleteFolder($this->getPath(), $commit, $force);
        }

        return $success;
    }

    /**
     * Restores this item to the given destination.
     *
     * @param string $destination The destination of the item restore.
     * @param string $restoreMethod The restore method.
     * @param string $restoreArgument The restore argument.
     * @return The success/fail response of the restore operation.
     */
    public function restore($destination, $restoreMethod = RestoreMethod::FAIL, $restoreArgument = null) {
        if (!is_string($destination)) {
            $destination = $destination->path();
        }

        $status = $this->restAdapter()->restore($this->getId(), $destination, $restoreMethod, $restoreArgument);
        if ($status) {
            $this->fullPath = $destination . '/' . $this->getId();

        } else {
            $this->restAdapter = null;
        }

        return $status;
    }

    /**
     * Retrieves the files history of this file.
     *
     * @return The file history response.
     */
    public function history() {
        return $this->restAdapter()->fileHistory($this);
    }
}