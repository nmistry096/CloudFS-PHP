<?php


/**
 * Bitcasa Client PHP SDK
 * Copyright (C) 2014 Bitcasa, Inc.
 *
 * This file contains an SDK in PHP for accessing the Bitcasa infinite drive.
 *
 * For support, please send email to support@bitcasa.com.
 */

require_once "HTTPConnect.php";
require_once "BitcasaConstants.php";
require_once "BitcasaUtils.php";
require_once "BitcasaFilesystem.php";


/**
 * Defines the credential properties.
 */
class Credential {

	private $endpoint;
	private $applicationContext;
	private $accessToken;
	private $tokenType;
	private $session;

	/**
	 * Initializes the Credentials instance.
	 *
	 * @param Session $session Session variable.
	 * @param string $endpoint The bitcasa endpoint.
	 */
	public function __construct($session = null, $endpoint = NULL) {
		$this->applicationContext = null;
		$this->endpoint = $endpoint;
		$this->session = $session;
	}

	/**
	 * Retrieves the credentials api endpoint.
	 *
	 * @return The api endpoint.
	 */
	public function getEndPoint() {
		return $this->endpoint;
	}

	/**
	 * Retrieves the application context.
	 *
	 * @return The application context.
	 */
	public function getApplicationContext() {
		return $this->applicationContext;
	}

	/**
	 * Retrieves the credentials access token.
	 *
	 * @return The access token.
	 */
	public function getAccessToken() {
		return $this->accessToken;
	}

	/**
	 * Sets the credentials access token.
	 *
	 * @param string $token The access token to be set.
	 */
	public function setAccessToken($token) {
		$this->accessToken = $token;
	}

	/**
	 * Retrieves the credential token type.
	 *
	 * @return The token type.
	 */
	public function getTokenType() {
		return $this->tokenType;
	}

	/**
	 * Sets the credential token type.
	 *
	 * @param string $type The token type to be set.
	 */
	public function setTokenType($type) {
		$this->tokenType = $type;
	}

	/**
	 * Retrieves the request url for credentials.
	 *
	 * @param string $method Request url method variable.
	 * @param string $operation Request url operation.
	 * @param mixed $params Parameters for request url.
	 * @return string The request url.
	 */
	public function getRequestUrl($method, $operation = null, $params = null) {
		return BitcasaUtils::getRequestUrl($this, $method, $operation, $params);
	}

	/**
	 * Retrieves the credential session.
	 *
	 * @return The session.
	 */
	public function getSession() {
		return $this->session;
	}
}

/**
 * Defines a bitcasa session.
 */
class Session {
 
	private $clientId;
	private $clientSecret;
	private $credential;
	private $bitcasaClientApi;
	private $debug;

	/**
	 * Initializes the Session instance.
	 *
	 * @param string $endpoint The bitcasa api endoint.
	 * @param string $clientId The app client id.
	 * @param string $clientSecret The app client secret.
	 */
    public function __construct($endpoint, $clientId, $clientSecret) {
		$applicationConext = null;
    	$this->clientId = $clientId;
    	$this->clientSecret = $clientSecret;
		$this->debug = getenv("BC_DEBUG") != null;
    	$this->credential = new Credential($this, $endpoint);
    	$this->bitcasaClientApi = new BitcasaApi($this->credential);
	}

	/**
	 * Authenticates with bitcasa.
	 *
	 * @param string $username The username.
	 * @param string $password The password.
	 * @return The authentication status.
	 */
	public function authenticate($username, $password) {
		$api = $this->getClientApi();
		$resp = $api->getAccessToken($this, $username, $password);
		if ($this->debug) {
			print "auth result: "; var_dump($resp);
		}
		return ($resp != null && isset($resp['access_token']));
	}

	/**
	 * Retrieves the bitcasa client api.
	 *
	 * @return The bitcasa client api.
	 */
	public function getClientApi() {
		return $this->bitcasaClientApi;
	}

	/**
	 * Retrieves the linked status of the app with bitcasa.
	 *
	 * @return The linked status.
	 */
    public function isLinked() {
    	if ($this->credential->getAccessToken() == null)
    		return false;
    	else
    		return true;
    }

	/**
	 * Unlink the app with bitcasa.
	 */
    public function unlink() {
    	$this->credential->setAccessToken(null);
    	$this->credential->setTokenType(null);
    }
    
    /**
     * Retrieves the user information from bitcasa.
	 * This method requires a request to network.
	 *
     * @throws IOException
     * @throws BitcasaException
     * @return Current Bitcasa User information
     */
    public function user() {
     	$userInfo = $this->bitcasaClientApi->getBitcasaAccountDataApi()->requestUserInfo();
    	return $userInfo;
    }
    
    /**
	 * Retrieves the account information from bitcasa.
     * This method requires a request to network.
	 *
     * @throws IOException
     * @throws BitcamixedsaException
     * @return Current Bitcasa Account information
     */
    public function account() {
		$accountInfo = $this->bitcasaClientApi->getBitcasaAccountDataApi()->requestAccountInfo();
    	return $accountInfo;
    }

	/**
	 * Retrieves the bitcasa filesystem.
	 *
	 * @return The bitcasa filesystem
	 */
    public function filesystem() {
    	return new Filesystem($this->bitcasaClientApi);
    }

	/**
	 * Retrieves the session client id.
	 *
	 * @return The client id.
	 */
	public function getClientId() {
		return $this->clientId;
	}

	/**
	 * Set the session client id.
	 *
	 * @param string $clientId The client Id to be set.
	 */
	public function setClientId($clientId) {
		$this->clientId = $clientId;
	}

	/**
	 * Retrieves the session client secret.
	 *
	 * @return The client secret.
	 */
	public function getClientSecret() {
		return $this->clientSecret;
	}

	/**
	 * Sets the session client secret.
	 *
	 * @param string $clientSecret The client secret to be set.
	 */
	public function setClientSecret($clientSecret) {
		$this->clientSecret = $clientSecret;
	}

	/**
	 * Retrieves the sessions bitcasa client api.
	 *
	 * @return The bitcasa client api.
	 */
	public function getBitcasaClientApi() {
		return $this->bitcasaClientApi;
	}

	/**
	 * Sets the sessions bitcasa client api.
	 *
	 * @param BitcasaClientApi $bitcasaClientApi The bitcasa client api to be set.
	 */
	public function setBitcasaClient(BitcasaClientApi $bitcasaClientApi) {
		$this->bitcasaClientApi = $bitcasaClientApi;
	}

	/**
	 * Retrieves the access token.
	 *
	 * @return The access token.
	 */
	public function getAccessToken() {
		return $this->credential->getAccessToken();
	}
	
}


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

		$connection->sendData($parameters);
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
		assert_path($parentpath, 1);
		assert_string($filename, 2);
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FOLDERS, $parentpath,
												array(BitcasaConstants::PARAM_OPERATION => BitcasaConstants::OPERATION_CREATE));
		$body = BitcasaUtils::generateParamsString(array("name" => $filename, "exists" => $exists));
		
		$connection->sendData($body);
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
		assert_string($path, 1);
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
		assert_string($path, 1);
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
		assert_string($path, 1);
		$connection = new HTTPConnect($this->credential->getSession());
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FOLDERS, $path . "/meta",
												array());
		$attrs['version-conflict'] = $conflict;
		$body = BitcasaUtils::generateParamsString($attrs);
		
		$connection->sendData($body);
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
		assert_string($path, 1);
		$connection = new HTTPConnect($this->credential->getSession());
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FILES, $path . "/meta",
												array());
		$attrs['version-conflict'] = $conflict;
		$body = BitcasaUtils::generateParamsString($attrs);
		
		$connection->sendData($body);
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
		assert_string($path, 1);
		assert_string($dest, 2);
		$connection = new HTTPConnect($this->credential->getSession());
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FOLDERS, $path,
												array(BitcasaConstants::PARAM_OPERATION => BitcasaConstants::OPERATION_COPY));
		$params = array("to" => $dest, "exists" => $exists);
		if ($name != null) {
			$params['name'] = $name;
		}

		$body = BitcasaUtils::generateParamsString($params);
		
		$connection->sendData($body);
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
		assert_string($path, 1);
		assert_string($dest, 2);
		$connection = new HTTPConnect($this->credential->getSession());
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FILES, $path,
												array(BitcasaConstants::PARAM_OPERATION => BitcasaConstants::OPERATION_COPY));

		$params = array("to" => $dest, "exists" => $exists);
		if ($name != null) {
			$params['name'] = $name;
		}
		$body = BitcasaUtils::generateParamsString($params);
		
		$connection->sendData($body);
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
		assert_path($path, 1);
		assert_path($dest, 2);
		$connection = new HTTPConnect($this->credential->getSession());
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FOLDERS, $path,
												array(BitcasaConstants::PARAM_OPERATION => BitcasaConstants::OPERATION_MOVE));
		$params = array("to" => $dest, "exists" => $exists);
		if ($name != null) {
			$params['name'] = $name;
		}
		$body = BitcasaUtils::generateParamsString($params);
		
		$connection->sendData($body);
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
		assert_path($path, 1);
		assert_path($dest, 2);
		$connection = new HTTPConnect($this->credential->getSession());
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FILES, $path,
												array(BitcasaConstants::PARAM_OPERATION => BitcasaConstants::OPERATION_MOVE));
		$params = array("to" => $dest, "exists" => $exists);
		if ($name != null) {
			$params['name'] = $name;
		}
		$body = BitcasaUtils::generateParamsString($params);
		
		$connection->sendData($body);
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
		assert_string($filepath);
		$params = array();
		$connection = new HTTPConnect($this->credential->getSession());
		$connection->raw();
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FILES, $parentpath,
												$params);
		if ($connection->post_multipart($url, $name, $filepath, $exists) <= 100) {
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
		assert_string($path, 1);
		assert_string($dest, 2);
		$connection = new HTTPConnect($this->credential->getSession());
		$params = array();
		$body = array("rescue-path" => $dest);
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_TRASH, $path, 
												$params);
		$body = BitcasaUtils::generateParamsString($body);
		
		$connection->sendData($body);
		if ($connection->post($url) <= 100) {
			return false;
		}

		return $connection->getResponse(true);
	}

	/**
	 * Retrieves the file history of a given item.
	 *
	 * @param string $path The path of the item for which the file history needs to be retrieved.
	 * @param int $start Start version.
	 * @param int $stop Stop version.
	 * @param int $limit The limit of history entries.
	 * @return File history entries.
	 * @throws InvalidArgument
	 */
    public function fileHistory($path, $start = 0, $stop = 0, $limit = 0) {
		assert_string($path, 1);
		$connection = new HTTPConnect($this->credential->getSession());
		$params = array();
		if ($start != 0) {
			$params['start'] = $start;
		}
		if ($stop != 0) {
			$params['stop'] = $stop;
		}
		if ($limit != 0) {
			$params['limit'] = $limit;
		}
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FILES, $path . "/versions", 
												$params);
		if ($connection->get($url) <= 100) {
			return false;
		}

		return $connection->getResponse(true);
	}

}
?>
