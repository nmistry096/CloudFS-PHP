<?php

/**
 * Bitcasa Client PHP SDK
 * Copyright (C) 2014 Bitcasa, Inc.
 *
 * This file contains an SDK in PHP for accessing the Bitcasa infinite drive.
 *
 * For support, please send email to support@bitcasa.com.
 */

require_once("BitcasaItems.php");
require_once("BitcasaApi.php");
require_once("BitcasaException.php");


class Filesystem {

	private $api;

    public function __construct($api) {
		$this->api = $api;
	}
 
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


    public function delete($items, $force = false) {
		if (!is_array($items)) {
			$items = array($items);
		}
		$res = array();
		$r = null;
		foreach ($items as $item) {
			if ($item->type() == "folder") {
				$r = $this->api->deleteFolder($item->path(), $force);
			} else {
				$r = $this->api->deleteFile($item->path());
			}
			$res[] = $r;
		}
		return $res;
	}


	public function create($parent, $name, $exists="overwrite") {
		$parentItem = null;
		if ($parent == null) {
			$parentPath = "/";
		} else if (!is_string($parent)) {
			$parentItem = $parent;
			$parentPath = $parent->path();
		} else {
			$parentPath = $parent;
		}

		$r = $this->api->createFolder($parentPath, $name, $exists);
		return Item::make($r, $parentPath, $this);
	}


    public function move($items, $destination, $exists = "fail") {
		assert_non_null($items, 1);
		if (!is_string($destination)) {
			$destination = $destination->path();
		}
		if (!is_array($items)) {
			$items = array($items);
		}
		$res = array();
		$r = null;
		foreach ($items as $item) {
			if ($item->type() == "folder") {
				$r = $this->api->moveFolder($item->path(), $destination, $item->name(), $exists);
			} else {
				$r = $this->api->moveFile($item->path(), $destination, $item->name(), $exists);
			}
			$res[] = $r;
		}
		return $res;
	}
 
    public function copy($items, $destination, $exists = "fail") {
		if (!is_array($items)) {
			$items = array($items);
		}
		$res = array();
		$r = null;
		foreach ($items as $item) {
			if ($item->type() == "folder") {
				$r = $this->api->copyFolder($item->path(), $destination, $item->name(), $exists);
			} else {
				$r = $this->api->copyFile($item->path(), $destination, $item->name(), $exists);
			}
			$res[] = $r;
		}
		return $res;
	}
 
    public function save($items, $conflict = "fail") {
		if (!is_array($items)) {
			$items = array($items);
		}
		$res = array();
		$r = null;
		foreach ($items as $item) {
			if ($item->type() == "folder") {
				$r = $this->api->alterFolder($item->path(), $item->changes(), $conflict);
			} else {
				$r = $this->api->alterFile($item->path(), $item->changes(), $conflict);
			}
			$res[] = $r;
		}
		return $res;
	}


	public function upload($parent, $path, $name = null, $exists = "overwrite") {
		$parentpath = "/";
		if (is_string($parent)) {
			$parentpath = $parent;
		} else if ($parent != null) {
			$parentpath = $parent->path();
		}

		$fp = $path;
		if ($name == null) {
			$name = basename($path);
		}
		$res = $this->api->uploadFile($parentpath, $name, $fp, $exists);
		return Item::make($res['result'], $parentpath, $this);
	}

 
	public function download($item, $file = null) {
		assert_non_null($item, 1);
		$path = $item;
		if (!is_string($item)) {
			$path = $item->path();
		}
		return $this->api->downloadFile($path, $file);
	}

 
    public function restore($items, $destination, $exists) {
		if (!is_array($items)) {
			$items = array($items);
		}

		$res = array();
		$r = null;
		foreach ($items as $item) {
			$r = $this->api->restore($item->path(), $destination);
			$res[] = $r;
		}
		return $res;
	}
 

    public function fileHistory($item, $start = -10, $stop = 0) {
		return $this->api->fileHistory($item->path(), $start, $stop);
	}

 
}
 
?>
