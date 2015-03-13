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

use CloudFS\Utils\Exists;
use CloudFS\Utils\VersionExists;
use CloudFS\Utils\RestoreMethod;

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
	 * @param object $restAdapter The restAdapter instance.
	 */
    public function __construct($restAdapter) {
		$this->restAdapter = $restAdapter;
	}

    /**
     * Retrieves the root directory.
     *
     * @return The root directory.
     */
    public function root(){
        $path = "/";
        $res = $this->restAdapter->getFolderMeta($path);
        $res = $res["result"]["meta"];
        return Item::make($res, $path, $this);
    }

	/**
	 * Retrieves the item array for a given directory.
	 *
	 * @param string|null $dir The directory path for which the items should be
	 * retrieved, if null root items are retrieved.
	 * @return The array of items at the given directory.
	 */
    public function getList($dir = null) {
		$path = "/";
		if ($dir != null) {
			if (is_string($dir)) {
				$path = $dir;
			} else {
				$path = $dir->getAbsolutePath();
			}
		}
		$resp = $this->restAdapter->getList($path);
		$items = $resp["result"]["items"];
		$lst = array();
		if ($items != null) {
			foreach ($items as $item) {
				$lst[] = Item::make($item, $dir, $this);
			}
		}
		return $lst;
	}

	/**
	 * Retrieves an item by the given path.
	 *
	 * @param string $path The item path.
	 * @return An instance of the item.
	 */
	public function getItem($path) {
		if ($path == null) {
			$path = "/";
		}
		if ($path != "/") {
			$dir = explode("/", $path);
			if (count($dir) <= 2) {
				$dir = "/";
			} else {
				array_pop($dir);
				$dir = implode("/", $dir);
			}
		}
		$res = $this->restAdapter->getItemMeta($path);
		$res = $res["result"];
		return Item::make($res, $dir, $this);
	}

    /**
     * Retrieves an item by the given path.
     *
     * @param string $path The file path.
     * @return An instance of the item of type Audio|Document|Photo|Video|File.
     */
    public function getFile($path) {
        if ($path == null) {
            $path = "/";
        }
        if ($path != "/") {
            $dir = explode("/", $path);
            if (count($dir) <= 2) {
                $dir = "/";
            } else {
                array_pop($dir);
                $dir = implode("/", $dir);
            }
        }
        $res = $this->restAdapter->getFileMeta($path);
        $res = $res["result"];
        return Item::make($res, $dir, $this);
    }

	/**
	 * Retrieves a folder by the given path.
	 *
	 * @param string $path The folder path.
	 * @return A folder instance.
	 */
	public function getFolder($path) {
		$dir = null;
		if ($path == null) {
			$path = "/";
		}
		if ($path != "/") {
			$dir = explode("/", $path);
			if (count($dir) <= 2) {
				$dir = "/";
			} else {
				array_pop($dir);
				$dir = implode("/", $dir);
			}
		}
		$res = $this->restAdapter->getFolderMeta($path);
		$res = $res["result"]["meta"];
		return Item::make($res, $dir, $this);
	}

	/**
	 * Delete multiple items from cloud storage.
	 *
	 * @param Item[] $items The array of items to delete.
	 * @param bool $force The flag to force delete items from cloud storage.
	 * @return The success/fail response of the delete operation.
	 */
    public function delete($items, $force = false) {
		if (!is_array($items)) {
			$items = array($items);
		}
		$res = array();
		$r = null;
		foreach ($items as $item) {
			/** @var \CloudFS\Item $item */
			if ($item->getType() == "folder") {
				$r = $this->restAdapter->deleteFolder($item->getPath(), $force);
			} else {
				$r = $this->restAdapter->deleteFile($item->getPath());
			}
			$res[] = $r;
		}
		return $res;
	}

    public function deleteTrash($items){

        if (!is_array($items)) {
            $items = array($items);
        }
        $res = array();
        $r = null;

        foreach ($items as $item) {
            /** @var \CloudFS\Item $item */
            $r = $this->restAdapter->deleteTrashItem($item['id']);
            $res[] = $r;
        }
        return $res;


    }

	/**
	 * Create a folder with supplied name under the given parent folders,
	 * folder path.
	 *
	 * @param Item $parent Folder item under which the new folder should be created.
	 * @param string $name The name of the folder to be created.
	 * @param string $exists Specifies the action to take if the folder already exists.
	 * @return A folder instance.
	 */
	public function create($parent, $name, $exists= Exists::OVERWRITE) {
		if ($parent == null) {
			$parentPath = "/";
		} else if (!is_string($parent)) {
			$parentPath = $parent->getPath();
		} else {
			$parentPath = $parent;
		}

		$r = $this->restAdapter->createFolder($parentPath, $name, $exists);
		return Item::make($r, $parentPath, $this);
	}

	/**
	 * Moves multiple items to a specified destination.
	 *
	 * @param Item[] $items The items to be moved.
	 * @param string $destination path to which the items should be moved to.
	 * @param string $exists Specifies the action to take if the item already exists.
	 * @return An associative array containing the items.
	 * @throws InvalidArgument
	 */
    public function move($items, $destination, $exists = Exists::FAIL) {
		//assert_non_null($items, 1);
		if (!is_string($destination)) {
			$destination = $destination->getPath();
		}
		if (!is_array($items)) {
			$items = array($items);
		}
		$res = array();
		$r = null;
		foreach ($items as $item) {
			if ($item->getType() == "folder") {
				$r = $this->restAdapter->moveFolder($item->getPath(), $destination, $item->getName(), $exists);
			} else {
				$r = $this->restAdapter->moveFile($item->getPath(), $destination, $item->getName(), $exists);
			}
			$res[] = $r;
		}
		return $res;
	}

	/**
	 * Copy multiple items to a specified destination.
	 *
	 * @param Item[] $items The items to be copied.
	 * @param string $destination Path to which the items should be copied to.
	 * @param string $exists Specifies the action to take if the item already exists.
	 * @return An associative array containing the items.
	 */
    public function copy($items, $destination, $exists = "fail") {
		if (!is_array($items)) {
			$items = array($items);
		}
		$res = array();
		$r = null;
		foreach ($items as $item) {
			if ($item->getType() == "folder") {
				$r = $this->restAdapter->copyFolder($item->getPath(), $destination, $item->getName(), $exists);
			} else {
				$r = $this->restAdapter->copyFile($item->getPath(), $destination, $item->getName(), $exists);
			}
			$res[] = $r;
		}
		return $res;
	}

	/**
	 * Update items on the cloud file system.
	 *
	 * @param Item[] $items The items to be updated.
	 * @param string $conflict The action to take if a conflict occurs.
	 * @return The success/fail response of the update operation.
	 */
    public function save($items, $conflict = "fail") {
		if (!is_array($items)) {
			$items = array($items);
		}
		$res = array();
		$r = null;
		foreach ($items as $item) {
			if ($item->getType() == "folder") {
				$r = $this->restAdapter->alterFolder($item->getPath(), $item->changes(), $conflict);
			} else {
				$r = $this->restAdapter->alterFile($item->getPath(), $item->changes(), $conflict);
			}
			$res[] = $r;
		}
		return $res;
	}

	public function alterFolder($path, array $values, $ifConflict = VersionExists::FAIL) {
		return $this->restAdapter->alterFolder($path, $values, $ifConflict);
	}

	public function alterFile($path, array $values, $ifConflict = VersionExists::FAIL) {
		return $this->restAdapter->alterFile($path, $values, $ifConflict);
	}

	/**
	 * Upload a file on to the given path.
	 *
	 * @param mixed $parent The parent folder path.
	 * @param string $path The upload file path.
	 * @param string $name The name under which the file should be saved. If null local file name will be used.
	 * @param string $exists The action to take if the item already exists.
	 * @return An instance of the uploaded item.
	 */
	public function upload($parent, $path, $name = null, $exists = "overwrite") {
		$parentPath = "/";
		if (is_string($parent)) {
			$parentPath = $parent;
		} else if ($parent != null) {
			$parentPath = $parent->getPath();
		}

		$fp = $path;
		if ($name == null) {
			$name = basename($path);
		}
		$res = $this->restAdapter->uploadFile($parentPath, $name, $fp, $exists);
		return Item::make($res['result'], $parentPath, $this);
	}

	/**
	 * Download an item from the cloud storage.
	 *
	 * @param Item $item The file to be downloaded.
	 * @param mixed $file
	 * @return The file content.
	 * @throws InvalidArgument
	 */
	public function download($item, $file = null) {
		//assert_non_null($item, 1);
		$path = $item;
		if (!is_string($item)) {
			$path = $item->getPath();
		}
		return $this->restAdapter->downloadFile($path, $file);
	}

	/**
	 * Restore a given set of items to the supplied destination.
	 *
	 * @param string $pathId The item id.
	 * @param string $destination The path the files are to be restored to
	 * @param string $restoreMethod The action to take if the item already exists.
     * @param string $restoreArgument The restore extra argument
	 * @return The True/False response of the restore operation.
	 */

    public function restore($pathId, $destination, $restoreMethod = RestoreMethod::FAIL, $restoreArgument = null) {
		$status = false;
        $result = $this->restAdapter->restore($pathId, $destination, $restoreMethod, $restoreArgument);
        if(isset($result['result']['success'])){
            $status = $result['result']['success'];
        }
		return $status;
	}

	/**
	 * Retrieves the file history of a given item.
	 *
	 * @param Item $item The item for which the file history needs to be retrieved.
	 * @param int $start The start version.
	 * @param int $stop The end version.
	 * @return File history entries.
	 */
    public function fileHistory($item, $start = -10, $stop = 0) {
		return $this->restAdapter->fileHistory($item->getPath(), $start, $stop);
	}

    /**
     * Retrieves the list of shares on the filesystem.
     *
     * @return The share list.
     */
	public function listShares() {
		$shares = array();
		$response = $this->restAdapter->shares();
		if (!empty($response) && !empty($response['result'])) {
			foreach($response['result'] as $result) {
				$shares[] = Share::getInstance($this, $result);
			}
		}

		return $shares;
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
		$share = null;
		$response = $this->restAdapter->createShare($path, $password);
		if (!empty($response) && !empty($response['result'])) {
			$share = Share::getInstance($this, $response['result']);
		}

		return $share;
	}

    /**
     * Retrieves the items for a supplied share key.
     *
     * @param string $shareKey The supplied share key.
     * @return An array of items for the share key.
     */
	public function browseShare($shareKey) {
		$items = array();
		$response = $this->restAdapter->browseShare($shareKey);
		if (!empty($response) && !empty($response['result'])) {
			foreach ($response['result']['items'] as $item) {
				$items[] = Item::make($item, null, $this);
			}
		}

		return $items;
	}

    /**
     * Deletes the share item for a supplied share key.
     *
     * @param string $shareKey The supplied share key.
     * @return The success/failure status of the delete operation.
     */
	public function deleteShare($shareKey) {
		return $this->restAdapter->deleteShare($shareKey);
	}

    /**
     * Retrieve the share item for a given share key to a path supplied.
     *
     * @param string $shareKey The supplied share key.
     * @param string $path The path to which the share files are retrieved to.
     * @param string $exists The action to take if the item already exists.
     * @return The success/failure status of the retrieve operation.
     */
	public function retrieveShare($shareKey, $path, $exists = Exists::RENAME) {
		return $this->restAdapter->retrieveShare($shareKey, $path, $exists);
	}

    /**
     * Alter the properties of a share item for a given share key with the supplied data.
     *
     * @param string $shareKey The supplied share key.
     * @param mixed[] $values The values to be changed.
     * @param string $password The share password.
     * @return An instance of the altered share.
     * @throws Exception\InvalidArgumentException
     */
	public function alterShare($shareKey, array $values, $password = null) {
		$share = null;
		$response = $this->restAdapter->alterShare($shareKey, $values, $password);
		if (!empty($response) && !empty($response['result'])) {
			$share = Share::getInstance($this, $response['result']);
		}

		return $share;
	}

    /**
     * Unlocks the share item of the supplied share key for the duration of the session.
     *
     * @param string $shareKey The supplied share key.
     * @param string $password The share password.
     * @return The success/failure status of the retrieve operation.
     * @throws Exception\InvalidArgumentException
     */
	public function unlockShare($shareKey, $password) {
		return $this->restAdapter->unlockShare($shareKey, $password);
	}

    /**
     * Retrieves the file history of a given file.
     *
     * @param File $file The item for which the file history needs to be retrieved.
     * @param int $startVersion The start version.
     * @param int $endVersion The end version.
     * @param int $limit how many versions to list in the result set
     * @return File history entries.
     */
    public function fileVersions($file, $startVersion = 0, $endVersion = null, $limit = 10) {
        return $this->restAdapter->fileVersions($file->getPath(), $startVersion, $endVersion, $limit);
    }

    /**
     * Streams the content of a given file
     *
     * @param File $file The file to be streamed.
     * @return The file stream.
     * @throws Exception\InvalidArgumentException
     */
    public function fileRead($file){
        return $this->restAdapter->fileRead($file->getPath(), $file->getName(), $file->getSize());
    }

	/**
	 * Browses the Trash metafolder on the authenticated user’s account.
	 */
	public function listTrash(){
		return $this->restAdapter->listTrash();
	}

}
?>
