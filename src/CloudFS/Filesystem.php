<?php

/**
 * Bitcasa Client PHP SDK
 * Copyright (C) 2014 Bitcasa, Inc.
 *
 * This file contains an SDK in PHP for accessing the Bitcasa infinite drive.
 *
 * For support, please send email to support@bitcasa.com.
 */

namespace CloudFS;

/**
 * Defines the Bitcasa file system.
 */
class Filesystem {

    /**
     * @var \CloudFS\RESTAdapter The bitcasa restAdapter instance.
     */
    private $restAdapter;

    /**
     * Initialize the Filesystem instance.
     *
     * @param \CloudFS\RESTAdapter $restAdapter The restAdapter instance.
     */
    public function __construct($restAdapter) {
        $this->restAdapter = $restAdapter;
    }

    /**
     * Retrieves the root directory.
     *
     * @return The root directory.
     */
    public function root() {
        return $this->restAdapter->getFolderMeta(null);
    }

    /**
     * Browses the Trash meta folder on the authenticated user’s account.
     */
    public function listTrash() {
        return $this->restAdapter->listTrash();
    }

    /**
     * Retrieves an item by the given path.
     *
     * @param string $path The item path.
     * @return An instance of the item.
     */
    public function getItem($path) {
        return $this->restAdapter->getItemMeta($path);
    }

    /**
     * Retrieves the list of shares on the filesystem.
     *
     * @return The share list.
     */
    public function listShares() {
        return $this->restAdapter->shares();
    }

    /**
     * Create a share of an item at the supplied path.
     *
     * @param string $path The path of the item to be shared.
     * @param string $password The password of the shared to be created.
     * @return An instance of the share.
     * @throws Exception\InvalidArgumentException
     */
    public function createShare($path, $password = null) {
        return $this->restAdapter->createShare($path, $password);
    }

    /**
     * Retrieves the shared item for the specified key.
     *
     * @param string $shareKey The share key.
     * @param string $password The password for the share.
     * @return An instance of share.
     */
    public function retrieveShare($shareKey, $password = null) {
        $shares = $this->listShares();
        $sharedItem = null;
        foreach ($shares as $share) {
            /** @var \CloudFS\Share $share */
            if ($share->getShareKey() == $shareKey) {
                $sharedItem = $share;
                break;
            }
        }

        return $sharedItem;
    }
}

?>
