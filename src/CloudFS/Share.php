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
     * @var \CloudFS\Filesystem The file system instance.
     */
    private $fileSystem;

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

    public function getApplicationData() {
        return $this->applicationData;
    }

    public function getDateContentLastModified() {
        return $this->dateContentLastModified;
    }

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
     * @param mixed $result The json response retrieved from rest api.
     * @return A share instance.
     */
    public static function getInstance($fileSystem, $result) {
        $share = new Share();
        $share->fileSystem = $fileSystem;
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

    public function getList() {
        return $this->fileSystem->browseShare($this->shareKey);
    }

    public function delete() {
        return $this->fileSystem->deleteShare($this->shareKey);
    }

    public function receive($path = '/', $exists = Exists::RENAME) {
        return $this->fileSystem->retrieveShare($this->shareKey, $path, $exists);
    }

    public function changeAttributes(array $values, $password = null) {
        $success = false;
        $share = $this->fileSystem->alterShare($this->shareKey, $values, $password);
        if (!empty($share)) {
            $success = true;
        }

        return $success;
    }

    public function setName($newName, $password = null) {
        $success = false;
        $share = $this->fileSystem->alterShare($this->shareKey, array('name' => $newName), $password);
        if (!empty($share)) {
            $success = true;
        }

        return $success;
    }

    public function setPassword($newPassword, $oldPassword = null) {
        $success = false;
        $share = $this->fileSystem->alterShare($this->shareKey, array('password' => $newPassword), $oldPassword);
        if (!empty($share)) {
            $success = true;
        }

        return $success;
    }

}