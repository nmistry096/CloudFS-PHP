<?php

/**
 * Bitcasa Client PHP SDK
 * Copyright (C) 2014 Bitcasa, Inc.
 *
 * This file contains an SDK in PHP for accessing the Bitcasa infinite drive.
 *
 * For support, please send email to support@bitcasa.com.
 */

class Item {

	private $parent;
	private $full_path;
	private $data;
	private $api;
	private $change_list;

	/**
	 * Initializes the item instance.
	 *
	 * @param object $api The api instance.
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
	 * @param $key The supplied change key.
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
	 * @param string $path_string Path of an item.
	 * @return An array of path components.
	 */
	public static function components_from_path($path_string) {
		$paths = explode("/", rtrim($path_string, "/"));
        if ($paths[0] == '') {
			$path[0] = "/";
		}
        return $paths;
	}

	/**
	 * Retrieves the path given an item list.
	 *
	 * @param object $items The items whose path needs to be retrieved.
	 * @param bool $add_root Flag to add root to the retrieved path or not.
	 * @return Path of the item list.
	 */
	public static function path_from_item_list($items, $add_root=False) {
		$first = true;
		$path = "";
		foreach ($items as $item) {
			if ($first) {
				$first = false;
				$path .= $add_root ? "/" : "";
			} else {
				$path .= "/";
			}
			$path .= $item->id();
		}
		return $path;
	}

	/**
	 * Formats and returns the path of an item given an array of paths.
	 *
	 * @param mixed $components The array containing path elements.
	 * @param bool $add_root Flag to add root to the retrieved path or not.
	 * @return Formatted path for the given array.
	 */
	public static function path_from_components($components, $add_root=False) {
		$path = implode("/", $components);
		if ($add_root) {
			$path = "/" . $path;
		}
		return $path;
	}

	/**
	 * Retrieves the path for a given item.
	 *
	 * @param object $item The items whose path needs to be retrieved.
	 * @return string The path of the item.
	 */
    public function path_from_item($item = null) {
		if ($item == null) {
			$item = $this;
		}

		$path = array();
		while ($item != null) {
			array_unshift($path, $item);
			$item = $item->parent;
		}
		return path_from_components($path);
	}

	/**
	 * Retrieves an instance of an item for the supplied data.
	 *
	 * @param object $data The data needed to create an item.
	 * @param string $parentPath Parent path for the new item.
	 * @param object $api The api instance.
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
    public function name() {
		return $this->data['name'];
	}

	/**
	 * Sets the name of this item.
	 *
	 * @param $new_name The name of the item.
	 */
	public function set_name($new_name) {
		$this->change('name');
		$this->data['name'] = $new_name;
	}

	/**
	 * Retrieves the id of this item.
	 *
	 * @return The data id of the item.
	 */
    public function id() {
		return $this->data['id'];
	}

	/**
	 * Sets the id of this item - Not Allowed.
	 *
	 * @param string $new_id The new id to be set on the item.
	 * @throws OperationNotAllowed
	 */
    public function set_id($new_id) {
        throw new OperationNotAllowed("Setting the id of an Item");
	}

	/**
	 * Retrieves the parent id of this item.
	 *
	 * @return The parent id of this item.
	 */
	public function parent_id() {
		return $this->data['parent_id'];
	}

	/**
	 * Retrieves the type of this item.
	 *
	 * @return The type of this item.
	 */
    public function type() {
        return $this->data['type'];
	}

	/**
	 * Set the type of this item - Not Allowed.
	 *
	 * @param string $new_type The new type to be set on the item.
	 * @throws OperationNotAllowed
	 */
    public function set_type($new_type) {
        throw new OperationNotAllowed("Setting the type of an Item");
	}

	/**
	 * Retrieves the is mirrored flag of this item.
	 *
	 * @return The is mirrored flag of this item.
	 */
    public function is_mirrored() {
        return $this->data['is_mirrored'];
	}

	/**
	 * Sets the is mirrored flag of this item - Not Allowed.
	 *
	 * @param string $new_mirrored_flag The new mirrored flag to be set on the item.
	 * @throws OperationNotAllowed
	 */
    public function set_mirrored($new_mirrored_flag) {
        throw new OperationNotAllowed("Setting if an Item is mirrored");
	}

	/**
	 * Retrieve the content last modified date of this item.
	 *
	 * @return The content last modified date.
	 */
    public function date_content_last_modified() {
        return $this->data['date_content_last_modified'];
	}

	/**
	 * Sets the content last modified date of this item.
	 *
	 * @param string $new_date_content_last_modified The new content last modified date.
	 */
    public function set_date_content_last_modified($new_date_content_last_modified) {
        $this->change('date_content_last_modified');
        $this->data['date_content_last_modified'] = $new_date_content_last_modified;
	}

	/**
	 * Retrieves the created date of this item.
	 *
	 * @return The created date of this item.
	 */
    public function date_created() {
        return $this->data['date_created'];
	}

	/**
	 * Sets the created date of this item.
	 *
	 * @param string $new_date_created The new created date.
	 */
    public function set_date_created($new_date_created) {
        $this->change('date_created');
        $this->data['date_created'] = $new_date_created;
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
	 * @param string $new_version The new version.
	 */
    public function set_version($new_version) {
        $this->change('version');
        $this->data['version'] = $new_version;
	}

	/**
	 * Retrieve the parent path id of this item.
	 *
	 * @return the parent path id of this item.
	 */
    public function parent_path() {
        return $this->data['absolute_parent_path_id'];
	}

	/**
	 * Sets the parent path id of this item.
	 *
	 * @param string $new_absolute_parent_path_id The new parent path id.
	 */
    public function set_parent_path($new_absolute_parent_path_id) {
        $this->change('absolute_parent_path_id');
        $this->data['absolute_parent_path_id'] = $new_absolute_parent_path_id;
	}

	/**
	 * Retrieves the meta last modified date of this item.
	 *
	 * @return The meta last modified date of this item.
	 */
    public function date_meta_last_modified() {
        return $this->data['date_meta_last_modified'];
	}

	/**
	 * Sets the meta last modified date of this item.
	 *
	 * @param string $new_date_meta_last_modified The new meta last modified date.
	 */
	public function set_date_meta_last_modified($new_date_meta_last_modified) {
        $this->change('date_meta_last_modified');
        $this->data['date_meta_last_modified'] = $new_date_meta_last_modified;
	}

	/**
	 * Retrieves the application data of this item.
	 *
	 * @return The application data of this item.
	 */
    public function application_data() {
		return $this->data['application_data'];
	}

	/**
	 * Sets the new application data of this item.
	 *
	 * @param mixed $new_application_data The new application data.
	 */
    public function set_application_data($new_application_data) {
        $this->change('application_data');
        $this->data['application_data'] = $new_application_data;
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
    public function path() {
		return $this->full_path;
	}

	/**
	 * Moves this item to a given destination.
	 *
	 * @param string $dest The destination of the item move.
	 * @param string $exists The action to take if the item exists.
	 * @return The success/fail response of the move operation.
	 */
	public function move_to($dest, $exists = "fail") {
		return $this->api()->move($this, $dest, $exists);
	}

	/**
	 * Copy this item to a given destination.
	 *
	 * @param string $dest The destination of the item copy.
	 * @param string $exists The action to take if the item exists.
	 * @return The success/fail response of the copy operation.
	 */
    public function copy_to($dest, $exists = "fail") {
		return $this->api()->copy($this, $dest, $exists);
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
	 * @param string $if_conflict The action to take if a conflict occurs.
	 * @param bool $debug Debug flag.
	 * @return The success/fail response of the save operation.
	 */
    public function save($if_conflict="fail", $debug=False) {
        return $this->api()->save($this);
	}

	/**
	 * Restores this item to the given destination.
	 *
	 * @param string $dest The destination of the item restore.
	 * @return The success/fail response of the restore operation.
	 */
	public function restore($dest) {
		if (!is_string($dest)) {
			$dest = $dest->path();
		}
        return $this->api()->restore($this, $dest);
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



class Container extends Item {

	/**
	 * Initializes a new instance of Container.
	 *
	 * @param mixed $api
	 */
	public function __construct($api = null) {
		parent::__construct($api);
	}

	/**
	 * Retrieves the item list at this items path.
	 *
	 * @return The item list array.
	 */
	public function get_list() {
		return $this->api()->getList($this->path());
	}

	/**
	 * Creates a folder item under this item with the supplied name.
	 *
	 * @param string $name The name of the folder being created.
	 * @param string $exists The action to take if the folder already exists.
	 * @return Instance of the newly created folder.
	 */
	public function create($name, $exists="overwrite") {
		return $this->api()->create($this, $name, $exists);
	}

	/**
	 * Uploads a file under this item.
	 *
	 * @param string $path The path of the file to be uploaded.
	 * @param string $name The name of the file.
	 * @param string $exists The action to take if the file already exists.
	 * @return An instance of the uploaded item.
	 */
	public function upload($path, $name = null, $exists='fail') {
		return $this->api()->upload($this, $path, $name, $exists);
	}
}


class Folder extends Container {

	/**
	 * Initializes a new instance of Folder.
	 *
	 * @param mixed $api
	 */
	public function __construct($api = null) {
		parent::__construct($api);
	}
}


class File extends Item {

	/**
	 * Initializes a new instance of File.
	 *
	 * @param mixed $api
	 */
	public function __construct($api = null) {
		parent::__construct($api);
	}

	/**
	 * Downloads this file from the cloud.
	 *
	 * @param string $localPath The local path where the file is to be downloaded to.
	 */
	public function download($localPath) {
    	$this->api()->downloadFile($this, $localPath);
    }
}



class Video extends File {

	/**
	 * Initializes a new instance of Video.
	 *
	 * @param mixed $api
	 */
	public function __construct($api = null) {
		parent::__construct($api);
	}

}



class Photo extends File {

	/**
	 * Initializes a new instance of Photo.
	 *
	 * @param mixed $api
	 */
	public function __construct($api = null) {
		parent::__construct($api);
	}

}


class Document extends File {

	/**
	 * Initializes a new instance of Document.
	 *
	 * @param mixed $api
	 */
	public function __construct($api = null) {
		parent::__construct($api);
	}

}


class Audio extends File {

	/**
	 * Initializes a new instance of Audio.
	 *
	 * @param mixed $api
	 */
	public function __construct($api = null) {
		parent::__construct($api);
	}

}


?>
