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


	public function __construct($api = null) {
		$this->data = NULL;
		$this->parent = Null;
		$this->full_path = Null;
		$this->data = array();
		$this->api = $api;
		$this->changes = array();
	}


	public function api() {
		return $this->api;
	}
	

	public function change($key) {
		$this->change_list[] = $key;
	}


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


	public static function components_from_path($path_string) {
		$paths = explode("/", rtrim($path_string, "/"));
        if ($paths[0] == '') {
			$path[0] = "/";
		}
        return $paths;
	}


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


	public static function path_from_components($components, $add_root=False) {
		$path = implode("/", $components);
		if ($add_root) {
			$path = "/" . $path;
		}
		return $path;
	}


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


	public static function make($data, $parent = null, $api = null) {
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

		// parent could be an instance of Item or a path. If the value is null, empty or / then the parent is root.
		if ($parent == null) {
			$item->full_path = "/" . $item->data['id'];
		}
		else {
			if ($parent instanceof Container) {
				$item->parent = $parent;
				if ($parent->full_path == '/') {
					$item->full_path = $parent->full_path . $item->data['id'];
				}
				else {
					$item->full_path = $parent->full_path . '/' . $item->data['id'];
				}
			}
			elseif(is_string($parent) && $parent != "") {
				if ($parent == '/') {
					$item->full_path = $parent . $item->data['id'];
				}
				else {
					$item->full_path = $parent . '/' . $item->data['id'];
				}
			}
			else {
				$item->full_path = "/" . $item->data['id'];
			}
		}

		return $item;
	}


	protected function value($key, $default = null) {
		if (isset($this->data[$key])) {
			return $this->data[$key];
		} else {
			return $default;
		}
	}


    public function name() {
		return $this->data['name'];
	}


	public function set_name($new_name) {
		$this->change('name');
		$this->data['name'] = $new_name;
	}


    public function id() {
		return $this->data['id'];
	}


    public function set_id($new_id) {
        throw new OperationNotAllowed("Setting the id of an Item");
	}

	public function parent_id() {
		return $this->data['parent_id'];
	}


    public function type() {
        return $this->data['type'];
	}


    public function set_type($new_type) {
        throw new OperationNotAllowed("Setting the type of an Item");
	}


    public function is_mirrored() {
        return $this->data['is_mirrored'];
	}


    public function set_mirrored($new_mirrored_flag) {
        throw new OperationNotAllowed("Setting if an Item is mirrored");
	}


    public function date_content_last_modified() {
        return $this->data['date_content_last_modified'];
	}


    public function set_date_content_last_modified($new_date_content_last_modified) {
        $this->change('date_content_last_modified');
        $this->data['date_content_last_modified'] = $new_date_content_last_modified;
	}


    public function date_created() {
        return $this->data['date_created'];
	}


    public function set_date_created($new_date_created) {
        $this->change('date_created');
        $this->data['date_created'] = $new_date_created;
	}


    public function version() {
        return $this->data['version'];
	}


    public function set_version($new_version) {
        $this->change('version');
        $this->data['version'] = $new_version;
	}


    public function parent_path() {
        return $this->data['absolute_parent_path_id'];
	}


    public function set_parent_path($new_absolute_parent_path_id) {
        $this->change('absolute_parent_path_id');
        $this->data['absolute_parent_path_id'] = $new_absolute_parent_path_id;
	}


    public function date_meta_last_modified() {
        return $this->data['date_meta_last_modified'];
	}


	public function set_date_meta_last_modified($new_date_meta_last_modified) {
        $this->change('date_meta_last_modified');
        $this->data['date_meta_last_modified'] = $new_date_meta_last_modified;
	}


    public function application_data() {
		return $this->data['application_data'];
	}


    public function set_application_data($new_application_data) {
        $this->change('application_data');
        $this->data['application_data'] = $new_application_data;
	}


    public function url() {
		return $this->full_path;
	}


    public function path() {
		return $this->full_path;
	}


	public function move_to($dest) {
		return $this->fs->move($this, $dest);
	}


    public function copy_to($dest) {
		return $this->fs->copy($this, $dest);
	}


    public function delete($commit=False, $force=False) {
        return $this->fs->delete($this);
	}


    public function save($if_conflict="fail", $debug=False) {
        return $this->fs->save($this);
	}


	public function restore($dest) {
		if (!is_string($dest)) {
			$dest = $dest->path();
		}
        return $this->fs->restore($this, $dest);
	}

    public function history() {
		return $this->fs->fileHistory($this);
	}
}



class Container extends Item {


	public function __construct($api = null) {
		parent::__construct($api);
	}


	public function get_list() {
		return $this->api()->getList($this->path());
	}


	public function create($name) {
		return $this->api()->create($this, $name);
	}


	public function upload($path, $exists='fail') {
		$this->api()->upload($this, $path, $exists);
	}
}


class Folder extends Container {


	public function __construct($api = null) {
		parent::__construct($api);
	}
}


class File extends Item {


	public function __construct($api = null) {
		parent::__construct($api);
	}


	public function download($localPath) {
    	$this->api()->downloadFile($this, $localPath);
    }
}



class Video extends File {

	public function __construct($api = null) {
		parent::__construct($api);
	}

}



class Photo extends File {

	public function __construct($api = null) {
		parent::__construct($api);
	}

}


class Document extends File {

	public function __construct($api = null) {
		parent::__construct($api);
	}

}


class Audio extends File {

	public function __construct($api = null) {
		parent::__construct($api);
	}

}


?>
