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

use CloudFS\Utils\Assert;
use CloudFS\Utils\BitcasaConstants;

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
        $response = $this->restAdapter->getFolderMeta(null);
        return Item::make($response["result"]["meta"], BitcasaUtils::getParentPath(null), $this->restAdapter, null);
    }

    /**
     * Retrieves the item list in trash.
     */
    public function listTrash() {
        $response = $this->restAdapter->listTrash();
        $items = array();
        if ($response != null && isset($response['result']) && isset($response['result']['items'])) {
            $parentState = array(BitcasaConstants::KEY_IN_TRASH => true);
            foreach ($response['result']['items'] as $item) {
                $items[] = Item::make($item, null, $this->restAdapter, $parentState);
            }
        }

        return $items;
    }

    /**
     * Retrieves an item by the given path.
     *
     * @param string $path The item path.
     * @return An instance of the item.
     */
    public function getItem($path) {
        Assert::assertStringOrEmpty($path, 1);
        $response = $this->restAdapter->getItemMeta($path);
        return Item::make($response['result'], BitcasaUtils::getParentPath($path), $this->restAdapter, null);
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
     * @throws InvalidArgumentException
     */
    public function createShare($path, $password = null) {
        if (empty($path)) {
            throw new InvalidArgumentException('createShare function accepts a valid path or path array. Input was ' . $path);
        }
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
        Assert::assertStringOrEmpty($shareKey, 1);
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
