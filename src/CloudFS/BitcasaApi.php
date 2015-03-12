<?php

namespace CloudFS;

/**
 * Bitcasa Client PHP SDK
 * Copyright (C) 2014 Bitcasa, Inc.
 *
 * This file contains an SDK in PHP for accessing the Bitcasa infinite drive.
 *
 * For support, please send email to support@bitcasa.com.
 */

use CloudFS\Exception\InvalidArgumentException;
use CloudFS\Filesystem;
use CloudFS\Utils\BitcasaConstants;
use CloudFS\BitcasaUtils;
use CloudFS\HTTPConnect;
use CloudFS\Utils\Exists;


class BitcasaApi {

	private $credential;
	private $accessToken;
	private $debug;

	/**
	 * Initializes the bitcasa api instance.
	 *
	 * @param Credential $credential
	 */
	public function __construct($credential) {
		$this->accessToken = null;
		$this->credential = $credential;
		$this->debug = getenv("BC_DEBUG") != null;
	}

	/**
	 * Retrieves the CloudFS access token through an api request.
	 *
	 * @param Session $session The bitcasa session.
	 * @param string $username Bitcasa username.
	 * @param string $password Bitcasa password.
	 * @return The success status of retrieving the access token.
	 */
    public function getAccessToken($session, $username, $password) {

    	if ($this->credential != null
			&& $this->credential->getAccessToken() != null
			&& $this->credential->getTokenType() != null) {
    		return true;
		}
    	
		$now = time();
		$connection = new HTTPConnect($session);
		$this->accessToken = null;

		$date = strftime(BitcasaConstants::DATE_FORMAT, $now);
		$bodyparams = array();

		$bodyparams[BitcasaConstants::PARAM_GRANT_TYPE] = urlencode(BitcasaConstants::PARAM_PASSWORD);
		$bodyparams[BitcasaConstants::PARAM_PASSWORD] = urlencode($password);
		$bodyparams[BitcasaConstants::PARAM_USERNAME] = urlencode($username);
			
		$parameters = BitcasaUtils::generateParamsString($bodyparams);
		$url = BitcasaUtils::getRequestUrl($this->credential, BitcasaConstants::METHOD_OAUTH2, BitcasaConstants::METHOD_TOKEN, null);
		//generate authorization value
		$uri = BitcasaConstants::API_VERSION_2 . BitcasaConstants::METHOD_OAUTH2 . BitcasaConstants::METHOD_TOKEN;
		$authorizationValue = bitcasaUtils::generateAuthorizationValue($session, $uri, $parameters, $date);
			
		$connection->addHeader(BitcasaConstants::HEADER_CONTENT_TYPE, BitcasaConstants::FORM_URLENCODED);
		$connection->AddHeader(BitcasaConstants::HEADER_DATE, $date);
		$connection->AddHeader(BitcasaConstants::HEADER_AUTORIZATION, $authorizationValue);

		$connection->setData($parameters);
		$status = $connection->post($url);
		$resp = null;

		if (BitcasaUtils::isSuccess($status)) {
			$resp = $connection->getResponse(true, false);

			if (isset($resp["access_token"])) {
				$this->credential->setAccessToken($resp["access_token"]);
			}

			if (isset($resp["token_type"])) {
				$this->credential->setTokenType($resp["token_type"]);
			}

			if ($this->debug) {
				var_dump($resp);
			}
			
			return true;
		}
		return false;
	}

	/**
	 * Retrieves the item list if a prent item is given, else returns the list
	 * of items under root.
	 *
	 * @param string $parent The parent for which the items should be retrieved for.
	 * @param int $version Version filter for items being retrieved.
	 * @param int $depth Depth variable for how many levels of items to be retrieved.
	 * @param mixed $filter Variable to filter the items being retrieved.
	 * @return The item list.
	 * @throws Exception
	 */
	public function getList($parent = null, $version = 0, $depth = 0, $filter = null) {
		$params = array();
		$endpoint = BitcasaConstants::METHOD_FOLDERS;

		if ($parent == null) {
			$endpoint .= "/";
		} else if (!is_string($parent)) {
			throw new Exception("Invalid parent path");
		} else {
			$endpoint .= $parent;
		}

		if ($version > 0) {
			$params[BitcasaConstants::PARAM_VERSION] = $version;
		}
		if ($depth > 0) {
			$params[BitcasaConstants::PARAM_DEPTH] = $depth;
		}
		if ($filter != null) {
			$params[BitcasaConstants::PARAM_FILTER] = $filter;
		}

		$connection = new HTTPConnect($this->credential->getSession());
		$url = $this->credential->getRequestUrl($endpoint, null, $params);

		if (!BitcasaUtils::isSuccess($connection->get($url))) {
			return null;
		}

		return $connection->getResponse(true);
	}

	/**
	 * Retrieves the meta data of a file at a given path.
	 *
	 * @param string $path The path of the item.
	 * @return The meta data of the item.
	 * @throws Exception
	 */
	public function getFileMeta($path) {
		$params = array();
		$endpoint = BitcasaConstants::METHOD_FILES;

		if ($path == null) {
			$endpoint .= "/";
		} else if (!is_string($path)) {
			throw new Exception("Invalid parent path");
		} else {
			$endpoint .= $path;
		}
		if (substr($endpoint, -1) != "/") {
			$endpoint .= "/";
		}
		$endpoint .= "meta";

		$connection = new HTTPConnect($this->credential->getSession());
		$url = $this->credential->getRequestUrl($endpoint, null, $params);

		if (!BitcasaUtils::isSuccess($connection->get($url))) {
			return null;
		}

		return $connection->getResponse(true);
	}



	/**
	 * Retrieves the meta data of a folder at a given path.
	 *
	 * @param string $path The path of the item.
	 * @return The meta data of the item.
	 * @throws Exception
	 */
	public function getFolderMeta($path) {
		$params = array();
		$endpoint = BitcasaConstants::METHOD_FOLDERS;

		if ($path == null) {
			$endpoint .= "/";
		} else if (!is_string($path)) {
			throw new Exception("Invalid parent path");
		} else {
			$endpoint .= $path;
		}
		if (substr($endpoint, -1) != "/") {
			$endpoint .= "/";
		}
		$endpoint .= "meta";

		$connection = new HTTPConnect($this->credential->getSession());
		$url = $this->credential->getRequestUrl($endpoint, null, $params);

		if (!BitcasaUtils::isSuccess($connection->get($url))) {
			return null;
		}

		return $connection->getResponse(true);
	}

	/**
	 * Create a folder at a given path with the supplied name.
	 *
	 * @param string $parentpath The folder path under which the new folder should be created.
	 * @param string $filename The name for the folder to be created.
	 * @param string $exists Specifies the action to take if the folder already exists.
	 * @return An instance of the newly created item of type Folder.
	 * @throws InvalidArgument]
	 */
	public function createFolder($parentpath, $filename, $exists = Exists::FAIL) {
		$connection = new HTTPConnect($this->credential->getSession());
		if ($parentpath == null) {
			$parentpath = "/";
		}
		//assert_path($parentpath, 1);
		//assert_string($filename, 2);
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FOLDERS, $parentpath,
												array(BitcasaConstants::PARAM_OPERATION => BitcasaConstants::OPERATION_CREATE));
		$body = BitcasaUtils::generateParamsString(array("name" => $filename, "exists" => $exists));
		
		$connection->setData($body);
		if ($this->debug) {
			var_dump($url);
		}
		if ($connection->post($url) <= 100) {
			return false;
		}

		$resp = $connection->getResponse(true);
		if ($resp != null && isset($resp['result']) && isset($resp['result']['items']) ) {
			return $resp['result']['items'][0];
		}
		return null;
	}

	/**
	 * Delete a folder from cloud storage.
	 *
	 * @param string $path The path of the folder to be deleted.
	 * @param bool $force The flag to force delete the folder from cloud storage.
	 * @return The success/fail response of the delete operation.
	 */
	public function deleteFolder($path, $force = false) {
		//assert_string($path, 1);
		$connection = new HTTPConnect($this->credential->getSession());
		$force_option = array();
		if ($force == true) {
			$force_option["force"] = "true";
		}

		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FOLDERS, $path,
												$force_option);
		
		if ($connection->delete($url) <= 100) {
			return false;
		}

		$res = $connection->getResponse(true);
		return $res;
	}

	/**
	 * Delete a file from cloud storage.
	 *
	 * @param string $path The path of the file to be deleted.
	 * @param bool $force The flag to force delete the file from cloud storage.
	 * @return The success/fail response of the delete operation.
	 */
	public function deleteFile($path, $force = false) {
		//assert_string($path, 1);
		$connection = new HTTPConnect($this->credential->getSession());
		$force_option = array();
		if ($force == true) {
			$force_option["force"] = "true";
		}

		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FILES, $path,
												$force_option);
		
		if ($connection->delete($url) <= 100) {
			return false;
		}

		$res = $connection->getResponse(true);
		return $res;
	}

	/**
	 * Alter the attributes of the folder at a given path.
	 *
	 * @param string $path The folder path.
	 * @param mixed $attrs The attributes to be altered.
	 * @param string $conflict Specifies the action to take if a conflict occurs.
	 * @return The success/fail response of the alter operation.
	 * @throws InvalidArgument
	 */
	public function alterFolder($path, $attrs, $conflict = "fail") {
		//assert_string($path, 1);
		$connection = new HTTPConnect($this->credential->getSession());
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FOLDERS, $path . "/meta",
												array());
		$attrs['version-conflict'] = $conflict;
		$body = BitcasaUtils::generateParamsString($attrs);
		
		$connection->setData($body);
		if ($connection->post($url) <= 100) {
			return false;
		}

		return $connection->getResponse(true);
	}

	/**
	 * Alter the attributes of the file at a given path.
	 *
	 * @param string $path The file path.
	 * @param mixed $attrs The attributes to be altered.
	 * @param string $conflict Specifies the action to take if a conflict occurs.
	 * @return The success/fail response of the alter operation.
	 * @throws InvalidArgument
	 */
	public function alterFile($path, $attrs, $conflict = "fail") {
		//assert_string($path, 1);
		$connection = new HTTPConnect($this->credential->getSession());
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FILES, $path . "/meta",
												array());
		$attrs['version-conflict'] = $conflict;
		$body = BitcasaUtils::generateParamsString($attrs);
		
		$connection->setData($body);
		if ($connection->post($url) <= 100) {
			return false;
		}

		return $connection->getResponse(true);
	}

	/**
	 * Copy a folder at a given path to a specified destination.
	 *
	 * @param string $path The path of the folder to be copied.
	 * @param string $dest Path to which the folder should be copied to.
	 * @param string $name Name of the newly copied folder.
	 * @param string $exists Specifies the action to take if the folder already exists.
	 * @return The success/fail response of the copy operation
	 */
	public function copyFolder($path, $dest, $name = null, $exists = "fail") {
		//assert_string($path, 1);
		//assert_string($dest, 2);
		$connection = new HTTPConnect($this->credential->getSession());
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FOLDERS, $path,
												array(BitcasaConstants::PARAM_OPERATION => BitcasaConstants::OPERATION_COPY));
		$params = array("to" => $dest, "exists" => $exists);
		if ($name != null) {
			$params['name'] = $name;
		}

		$body = BitcasaUtils::generateParamsString($params);
		
		$connection->setData($body);
		if ($connection->post($url) <= 100) {
			return false;
		}

		return $connection->getResponse(true);
	}

	/**
	 * Copy a file at a given path to a specified destination.
	 *
	 * @param string $path The path of the file to be copied.
	 * @param string $dest Path to which the file should be copied to.
	 * @param string $name Name of the newly copied file.
	 * @param string $exists Specifies the action to take if the file already exists.
	 * @return The success/fail response of the copy operation
	 */
	public function copyFile($path, $dest, $name = null, $exists = "fail") {
		//assert_string($path, 1);
		//assert_string($dest, 2);
		$connection = new HTTPConnect($this->credential->getSession());
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FILES, $path,
												array(BitcasaConstants::PARAM_OPERATION => BitcasaConstants::OPERATION_COPY));

		$params = array("to" => $dest, "exists" => $exists);
		if ($name != null) {
			$params['name'] = $name;
		}
		$body = BitcasaUtils::generateParamsString($params);
		
		$connection->setData($body);
		if ($connection->post($url) <= 100) {
			return false;
		}

		return $connection->getResponse(true);
	}

	/**
	 * Move a folder at a given path to a specified destination.
	 *
	 * @param string $path The path of the folder to be moved.
	 * @param string $dest Path to which the folder should be moved to.
	 * @param string $name Name of the newly moved folder.
	 * @param string $exists Specifies the action to take if the folder already exists.
	 * @return The success/fail response of the move operation
	 */
	public function moveFolder($path, $dest, $name = null, $exists = "fail") {
		//assert_path($path, 1);
		//assert_path($dest, 2);
		$connection = new HTTPConnect($this->credential->getSession());
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FOLDERS, $path,
												array(BitcasaConstants::PARAM_OPERATION => BitcasaConstants::OPERATION_MOVE));
		$params = array("to" => $dest, "exists" => $exists);
		if ($name != null) {
			$params['name'] = $name;
		}
		$body = BitcasaUtils::generateParamsString($params);
		
		$connection->setData($body);
		if ($connection->post($url) <= 100) {
			return false;
		}

		return $connection->getResponse(true);
	}

	/**
	 * Move a file at a given path to a specified destination.
	 *
	 * @param string $path The path of the file to be moved.
	 * @param string $dest Path to which the file should be moved to.
	 * @param string $name Name of the newly moved file.
	 * @param string $exists Specifies the action to take if the file already exists.
	 * @return The success/fail response of the move operation
	 */
	public function moveFile($path, $dest, $name = null, $exists = "fail") {
		//assert_path($path, 1);
		//assert_path($dest, 2);
		$connection = new HTTPConnect($this->credential->getSession());
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FILES, $path,
												array(BitcasaConstants::PARAM_OPERATION => BitcasaConstants::OPERATION_MOVE));
		$params = array("to" => $dest, "exists" => $exists);
		if ($name != null) {
			$params['name'] = $name;
		}
		$body = BitcasaUtils::generateParamsString($params);
		
		$connection->setData($body);
		if ($connection->post($url) <= 100) {
			return false;
		}

		return $connection->getResponse(true);
	}

	/**
	 * Download a file from the cloud storage.
	 *
	 * @param string $path Path of the file to be downloaded.
	 * @param mixed $file The file container for which the item will be downloaded to
	 * @return The download file/link
	 */
	public function downloadFile($path, $file = null) {
		$params = array();
		$connection = new HTTPConnect($this->credential->getSession());
		$connection->raw();
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FILES, $path,
												array());
		$s = $connection->get($url);
		if ($s <= 100) {
			return false;
		}
		return $connection->getResponse(true);
	}

	/**
	 * Upload a file on to the given path.
	 *
	 * @param string $parentpath The parent folder path to which the file is to be uploaded.
	 * @param string $name The upload file name.
	 * @param string $filepath The file path for the file to be downloaded.
	 * @param string $exists The action to take if the item already exists.
	 * @return An instance of the uploaded item.
	 */
	public function uploadFile($parentpath, $name, $filepath, $exists = "overwrite") {
		//assert_string($filepath);
		$params = array();
		$connection = new HTTPConnect($this->credential->getSession());
		$connection->raw();
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FILES, $parentpath,
												$params);
		if ($connection->postMultipart($url, $name, $filepath, $exists) <= 100) {
			return false;
		}
		// upload payload is raw download is json
		$this->raw = false;
		$resp = $connection->getResponse(true);
		return $resp;
	}

	/**
	 * Restores the file at a given path to a given destination.
	 *
	 * @param string $path The path of the file to be restored.
	 * @param string $dest The destination of the file to be restored to.
	 * @return The success/fail response of the restore operation.
	 * @throws InvalidArgument
	 */
    public function restore($path, $dest) {
		//assert_string($path, 1);
		//assert_string($dest, 2);
		$connection = new HTTPConnect($this->credential->getSession());
		$params = array();
		$body = array("rescue-path" => $dest);
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_TRASH, $path, 
												$params);
		$body = BitcasaUtils::generateParamsString($body);
		
		$connection->setData($body);
		if ($connection->post($url) <= 100) {
			return false;
		}

		return $connection->getResponse(true);
	}

	public function createShare($path, $password = null) {
		$response = null;
		if (!empty($path)) {
			$connection = new HTTPConnect($this->credential->getSession());
			$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_SHARES);
			$formParameters = array('path' => $path);
			if (!empty($password)) {
				$formParameters['password'] = $password;
			}
			$body = BitcasaUtils::generateParamsString($formParameters);
			$connection->setData($body);
			$status = $connection->post($url);
			$response = $connection->getResponse(true);
		}
		else {
			throw new InvalidArgumentException('createShare function accepts a valid path. Input was ' . $path);
		}

		return $response;
	}

	public function shares() {
		$response = null;
		$connection = new HTTPConnect($this->credential->getSession());
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_SHARES);
		$statusCode = $connection->get($url);
		if ($statusCode == 200) {
			$response = $connection->getResponse(true);
		}

		return $response;
	}

	public function browseShare($shareKey) {
		$response = null;
		if (!empty($shareKey)) {
			$connection = new HTTPConnect($this->credential->getSession());
			$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_SHARES, $shareKey . '/meta');
			$statusCode = $connection->get($url);
			if ($statusCode == 200) {
				$response = $connection->getResponse(true);
			}
		}

		return $response;
	}

	public function retrieveShare($shareKey, $path, $exists = Exists::OVERWRITE) {
		$success = false;
		if (!empty($shareKey) && !empty($path)) {
			$connection = new HTTPConnect($this->credential->getSession());
			$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_SHARES, $shareKey . '/');
			$body = BitcasaUtils::generateParamsString(array('path' => $path, 'exists' => $exists));
			$connection->setData($body);
			$status = $connection->post($url);
			$response = $connection->getResponse(true);
			if (!empty($response) && !empty($response['result'])) {
				$success = true;
			}
		}

		return $success;
	}

	public function deleteShare($shareKey) {
		$deleted = false;
		if (!empty($shareKey)) {
			$connection = new HTTPConnect($this->credential->getSession());
			$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_SHARES, $shareKey . '/');
			$status = $connection->delete($url);
			if ($status == 200) {
				$deleted = true;
			}
		}

		return $deleted;
	}

	public function unlockShare($shareKey, $password) {
		$success = false;
		if (empty($shareKey)) {
			throw new InvalidArgumentException('unlockShare function accepts a valid shareKey. Input was ' . $shareKey);
		}
		else if (empty($password)) {
			throw new InvalidArgumentException('unlockShare function accepts a valid password. Input was ' . $password);
		}
		else {
			$connection = new HTTPConnect($this->credential->getSession());
			$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_SHARES, $shareKey . '/unlock');
			$body = BitcasaUtils::generateParamsString(array('password' => $password));
			$connection->setData($body);
			$status = $connection->post($url);
			$response = $connection->getResponse(true);
			if (!empty($response) && !empty($response['result'])) {
				$success = true;
			}
		}

		return $success;
	}

	public function alterShare($shareKey, array $values, $password = null) {
		$response = null;
		if (!empty($shareKey)) {
			$connection = new HTTPConnect($this->credential->getSession());
			$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_SHARES, $shareKey . '/info');
			$formParameters = array();
			if (!empty($password)) {
				$formParameters['current_password'] = $password;
			}

			foreach($values as $key=>$value) {
				$formParameters[$key] = $value;
			}

			$body = BitcasaUtils::generateParamsString($formParameters);
			$connection->setData($body);
			$status = $connection->post($url);
			$response = $connection->getResponse(true);
		}
		else {
			throw new InvalidArgumentException('alterShare function accepts a valid shareKey. Input was ' . $shareKey);
		}

		return $response;
	}

    /**
     * @param $path
     * @param $startVersion
     * @param $endVersion
     * @param $limit
     * @return The|null
     * @throws InvalidArgumentException
     */
    public function fileVersions($path, $startVersion, $endVersion, $limit){
        $response = null;
        if(!empty($path)){
            $connection = new HTTPConnect($this->credential->getSession());
            $params = array();
            if ($startVersion != null) {
                $params['start-version'] = $startVersion;
            }
            if ($endVersion != null) {
                $params['stop-version'] = $endVersion;
            }
            if ($limit != null) {
                $params['limit'] = $limit;
            }
            $url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FILES,
                $path . BitcasaConstants::METHOD_VERSIONS, $params);
            $status = $connection->get($url);
            $response = $connection->getResponse(true);

        }else{
            throw new InvalidArgumentException('fileVersions function accepts a valid path. Input was ' . $path);
        }

        return $response;
    }

}

?>
