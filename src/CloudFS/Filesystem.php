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
	 * The bitcasa api instance.
	 */
	private $api;

	/**
	 * Initialize the Filesystem instance.
	 *
	 * @param object $api The api instance.
	 */
    public function __construct($api) {
		$this->api = $api;
	}

    /**
     * Retrieves the item array for root directory.
     *
     * @return The array of items at the root directory.
     */
    public function getRoot(){
        $path = "/";
        $resp = $this->api->getList($path);
        $items = $resp["result"]["items"];
        $lst = array();
        if ($items != null) {
            foreach ($items as $item) {
                $lst[] = Item::make($item, $path, $this);
            }
        }
        return $lst;

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
		$resp = $this->api->getList($path);
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
		$res = $this->api->getFileMeta($path);
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
		$res = $this->api->getFolderMeta($path);
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
				$r = $this->api->deleteFolder($item->getPath(), $force);
			} else {
				$r = $this->api->deleteFile($item->getPath());
			}
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
	public function create($parent, $name, $exists="overwrite") {
		if ($parent == null) {
			$parentPath = "/";
		} else if (!is_string($parent)) {
			$parentPath = $parent->getPath();
		} else {
			$parentPath = $parent;
		}

		$r = $this->api->createFolder($parentPath, $name, $exists);
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
    public function move($items, $destination, $exists = "fail") {
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
				$r = $this->api->moveFolder($item->getPath(), $destination, $item->getName(), $exists);
			} else {
				$r = $this->api->moveFile($item->getPath(), $destination, $item->getName(), $exists);
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
				$r = $this->api->copyFolder($item->getPath(), $destination, $item->getName(), $exists);
			} else {
				$r = $this->api->copyFile($item->getPath(), $destination, $item->getName(), $exists);
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
			if ($item->type() == "folder") {
				$r = $this->api->alterFolder($item->getPath(), $item->changes(), $conflict);
			} else {
				$r = $this->api->alterFile($item->getPath(), $item->changes(), $conflict);
			}
			$res[] = $r;
		}
		return $res;
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
		$res = $this->api->uploadFile($parentPath, $name, $fp, $exists);
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
		return $this->api->downloadFile($path, $file);
	}

	/**
	 * Restore a given set of items to the supplied destination.
	 *
	 * @param Item[] $items The items to be restored.
	 * @param string $destination The path the files are to be restored to
	 * @param string $exists The action to take if the item already exists.
	 * @return The success/fail response of the restore operation.
	 */
    public function restore($items, $destination, $exists) {
		if (!is_array($items)) {
			$items = array($items);
		}

		$res = array();
		$r = null;
		foreach ($items as $item) {
			$r = $this->api->restore($item->getPath(), $destination);
			$res[] = $r;
		}
		return $res;
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
		return $this->api->fileHistory($item->getPath(), $start, $stop);
	}

}
 
?>
