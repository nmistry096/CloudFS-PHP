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


	public function __construct($session = null, $endpoint = NULL) {
		$this->applicationContext = null;
		$this->endpoint = $endpoint;
		$this->session = $session;
	}


	public function getEndPoint() {
		return $this->endpoint;
	}


	public function getApplicationContext() {
		return $this->applicationContext;
	}


	public function getAccessToken() {
		return $this->accessToken;
	}


	public function setAccessToken($token) {
		$this->accessToken = $token;
	}



	public function getTokenType() {
		return $this->tokenType;
	}


	public function setTokenType($type) {
		$this->tokenType = $type;
	}

	public function getRequestUrl($method, $operation = null, $params = null) {
		return BitcasaUtils::getRequestUrl($this, $method, $operation, $params);
	}


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

    public function __construct($endpoint, $clientId, $clientSecret) {
		$applicationConext = null;
    	$this->clientId = $clientId;
    	$this->clientSecret = $clientSecret;
		$this->debug = getenv("BC_DEBUG") != null;
    	$this->credential = new Credential($this, $endpoint);
    	$this->bitcasaClientApi = new BitcasaApi($this->credential);
	}


	/**
	 * Authenticates with the bitcasa.
	 *
	 * @param $username The username.
	 * @param $password The password.
	 * @return bool
	 */
	public function authenticate($username, $password) {
		$api = $this->getClientApi();
		$resp = $api->getAccessToken($this, $username, $password);
		if ($this->debug) {
			print "auth result: "; var_dump($resp);
		}
		return ($resp != null && isset($resp['access_token']));
	}


	public function getClientApi() {
		return $this->bitcasaClientApi;
	}


    public function isLinked() {
    	if ($this->credential->getAccessToken() == null)
    		return false;
    	else
    		return true;
    }


    public function unlink() {
    	$this->credential->setAccessToken(null);
    	$this->credential->setTokenType(null);
    }
    
    /**
     * This method requires a request to network
     * @return
     * @throws IOException
     * @throws BitcasaException
     * @return current Bitcasa User information
     */
    public function user() {
     	$userInfo = $this->bitcasaClientApi->getBitcasaAccountDataApi()->requestUserInfo();
    	return $userInfo;
    }
    
    /**
     * This method requires a request to network
     * @return
     * @throws IOException
     * @throws BitcasaException
     * @return current Bitcasa Account information
     */
    public function account() {
		$accountInfo = $this->bitcasaClientApi->getBitcasaAccountDataApi()->requestAccountInfo();
    	return $accountInfo;
    }
    
    public function filesystem() {
    	return new Filesystem($this->bitcasaClientApi);
    }

	public function getClientId() {
		return $this->clientId;
	}

	public function setClientId($clientId) {
		$this->clientId = $clientId;
	}

	public function getClientSecret() {
		return $this->clientSecret;
	}

	public function setClientSecret($clientSecret) {
		$this->clientSecret = $clientSecret;
	}

	public function getBitcasaClientApi() {
		return $this->bitcasaClientApi;
	}

	public function setBitcasaClient(BitcasaClientApi $bitcasaClientApi) {
		$this->bitcasaClientApi = $bitcasaClientApi;
	}

	public function getAccessToken() {
		return $this->credential->getAccessToken();
	}
	
}


class BitcasaApi {

	private $credential;
	private $accessToken;
	private $debug;

	public function __construct($credential) {
		$this->accessToken = null;
		$this->credential = $credential;
		$this->debug = getenv("BC_DEBUG") != null;
	}

	/**
	 * an api request to CloudFS server to get access token
	 * 
	 * @param session
	 * @param username
	 * @param password
	 * @throws IOException
	 * @throws BitcasaException
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
    


	public function createFolder($parentpath, $filename, $exists = Exists::FAIL) {
		$connection = new HTTPConnect($this->credential->getSession());
		if ($parentpath == null) {
			$parentpath = "/";
		}
		assert_path($parentpath, 1);
		assert_string($filename, 2);
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FOLDERS, $parentpath,
												array(BitcasaConstants::PARAM_OPERATION => BitcasaConstants::OPERATION_CREATE));
		$body = BitcasaUtils::generateParamsString(array("name" => $filename,
														 "exists" => $exists));
		
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



	public function copyFolder($path, $dest, $name = null, $exists = "fail") {
		assert_string($path, 1);
		assert_string($dest, 2);
		$connection = new HTTPConnect($this->credential->getSession());
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FOLDERS, $path,
												array(BitcasaConstants::PARAM_OPERATION => BitcasaConstants::OPERATION_COPY));
		$body = BitcasaUtils::generateParamsString(array("to" => $dest,
														 "exists" => $exists));
		if ($name != null) {
			$body['name'] = $name;
		}
		
		$connection->sendData($body);
		if ($connection->post($url) <= 100) {
			return false;
		}

		return $connection->getResponse(true);
	}



	public function copyFile($path, $dest, $name = null, $exists = "fail") {
		assert_string($path, 1);
		assert_string($dest, 2);
		$connection = new HTTPConnect($this->credential->getSession());
		$url = $this->credential->getRequestUrl(BitcasaConstants::METHOD_FILES, $path,
												array(BitcasaConstants::PARAM_OPERATION => BitcasaConstants::OPERATION_COPY));
		$body = BitcasaUtils::generateParamsString(array("to" => $dest,
														 "exists" => $exists));
		if ($name != null) {
			$body['name'] = $name;
		}
		
		$connection->sendData($body);
		if ($connection->post($url) <= 100) {
			return false;
		}

		return $connection->getResponse(true);
	}


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
