<?php

namespace CloudFS;

use CloudFS\Utils\Exists;

class Share {

    private $shareKey;
    private $shareType;
    private $name;
    private $url;
    private $shortUrl;
    private $dateCreated;
    private $size;

    /**
     * @var array The application data.
     */
    private $applicationData;

    /**
     * @var int The content last modified unix timestamp.
     */
    private $dateContentLastModified;

    /**
     * @var int The meta last modified unix timestamp.
     */
    private $dateMetaLastModified;

    /**
     * @var \CloudFS\RESTAdapter The rest adapter instance.
     */
    private $restAdapter;

    /**
     * Retrieves the  share key.
     *
     * @return The share key.
     */
    public function getShareKey() {
        return $this->shareKey;
    }

    /**
     * Retrieves the  share type.
     *
     * @return The share type.
     */
    public function getShareType() {
        return $this->shareType;
    }

    /**
     * Retrieves the  share name.
     *
     * @return The share name.
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Retrieves the  url.
     *
     * @return The share url.
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Retrieves the  short url.
     *
     * @return The short url.
     */
    public function getShortUrl() {
        return $this->shortUrl;
    }

    /**
     * Retrieves the created date.
     *
     * @return The created date.
     */
    public function getDateCreated() {
        return $this->dateCreated;
    }

    /**
     * Retrieves the  share size.
     *
     * @return The share size.
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * Retrieves the application data.
     *
     * @return The application data.
     */
    public function getApplicationData() {
        return $this->applicationData;
    }

    /**
     * Retrieves the content last modified date.
     *
     * @return The content last modified date.
     */
    public function getDateContentLastModified() {
        return $this->dateContentLastModified;
    }

    /**
     * Retrieves the content meta last modified date.
     *
     * @return The content meta last modified date.
     */
    public function getDateMetaLastModified() {
        return $this->dateMetaLastModified;
    }

    /**
     * Private constructor to avoid creating new share objects.
     */
    private function __construct() {

    }

    /**
     * Retrieves a share instance from the supplied result.
     *
     * @param \CloudFS\RESTAdapter $restAdapter The rest adapter instance.
     * @param mixed $result The json response retrieved from rest api.
     * @return A share instance.
     */
    public static function getInstance($restAdapter, $result) {
        $share = new Share();
        $share->restAdapter = $restAdapter;
        $share->shareKey = $result['share_key'];
        $share->shareType = $result['share_type'];
        $share->name = $result['share_name'];
        if (!empty($result['url'])) {
            $share->url = $result['url'];
        }
        $share->shortUrl = $result['short_url'];
        $share->dateCreated = $result['date_created'];
        $share->size = $result['share_size'];

        if (!empty($result['single_item'])) {
            $share->applicationData = $result['single_item']['application_data'];
            $share->dateContentLastModified = $result['single_item']['date_content_last_modified'];
            $share->dateMetaLastModified = $result['single_item']['date_meta_last_modified'];
        }

        return $share;
    }

    /**
     * Lists the items for the share key.
     *
     * @return The list of items for the share key.
     */
    public function getList() {
        return $this->restAdapter->shares();
    }

    /**
     * Deletes the item for the share key.
     * 
     * @return The success/fail response of the delete operation.
     */
    public function delete() {
        return $this->restAdapter->deleteShare($this->shareKey);
    }

    /**
     * Adds all shared items for the given share key to the path supplied
     *
     * @param string $path The path to which the share files are added.
     * @param string $exists  The action to take if the item already exists.
     * @return bool The success/fail response of the receive operation.
     */
    public function receive($path = '/', $exists = Exists::RENAME) {
        return $this->restAdapter->receiveShare($this->shareKey, $path, $exists);
    }

    /**
     * Changes the attributes of a item for the given share key with the supplied values.
     *
     * @param array $values The values to which the attributes are changed to.
     * @param null $password The password for the change attribute operation.
     * @return The success/fail response of the change attributes operation.
     */
    public function changeAttributes(array $values, $password = null) {
        $success = false;
        $share = $this->restAdapter->alterShare($this->shareKey, $values, $password);
        if (!empty($share)) {
            $success = true;
        }

        return $success;
    }

    /**
     * Sets the name for a given user share.
     *
     * @param $newName The new name to be set.
     * @param null $password The password for the set name operation.
     * @return The success/fail response of the set name operation.
     */
    public function setName($newName, $password = null) {
        $success = false;
        $share = $this->restAdapter->alterShare($this->shareKey, array('name' => $newName), $password);
        if (!empty($share)) {
            $success = true;
        }

        return $success;
    }

    /**
     * Sets a new password the given user share.
     *
     * @param $newPassword The new password to be set.
     * @param null $oldPassword The old password for the set password operation.
     * @return bool The success/fail response of the set password operation.
     */
    public function setPassword($newPassword, $oldPassword = null) {
        $success = false;
        $share = $this->restAdapter->alterShare($this->shareKey, array('password' => $newPassword), $oldPassword);
        if (!empty($share)) {
            $success = true;
        }

        return $success;
    }

}