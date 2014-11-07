<?php

/**
 * Bitcasa Client PHP SDK
 * Copyright (C) 2014 Bitcasa, Inc.
 *
 * This file contains an SDK in PHP for accessing the Bitcasa infinite drive.
 *
 * For support, please send email to support@bitcasa.com.
 */

require_once "BitcasaException.php";


class HTTPConnect {

	private $headers;
	private $user_agent;
	private $curl;
	private $http_status;
	private $return_xfer;
	private $session;
	private $response;
	private $error_msg;
	private $error_code;
	private $data;
	private $datalen;
	private $is_raw;
	private $debug;
	private $boundary;
	private $eof;
	private $postdata;


	public function HTTPConnect($session = null) {
		$this->curl = null;
		$this->session = $session;
		$this->headers = array();
		$this->return_xfer = true;
		$this->response = null;
		$this->error_msg = null;
		$this->error_code = 0;
		$this->data = null;
		$this->datalen = 0;
		$this->postdata = null;
		$this->boundary = null;
		$this->eof = false;
		$this->is_raw = false;
		$debug = getenv("BC_DEBUG");
		if ($debug != null) {
			$this->debug = true;
		}
	}


	public function raw() {
		$this->is_raw = true;
	}

	public function addHeader($h, $v) {
		unset($this->headers[$h]);
		$this->headers[$h] = $v;
	}


	public function addMissingHeader($h, $v) {
		if (!isset($this->headers[$h])) {
			$this->headers[$h] = $v;
			return true;
		}
		return false;
	}


	public function hasHeader($h, $value = null)
	{
		if (!isset($this->headers[$h])) {
			return false;
		}
		if ($value != null) {
			return ($this->headers[$h] == $value);
		}
		return true;
	}

	public function getHeaders() {
		$result = array();
		foreach ($this->headers as $k => $v) {
			$h = $k . ": " . $v;
			$result[] = $h;
		}
		return $result;
	}


	public function sendData($data, $len = 0) {
		if ($len == 0) {
			$len = count($data);
		}
		$this->datalen = $len;
		$this->data = $data;
	}


	public function post($url) {
		$this->setup();
		if ($this->data != null && $this->datalen > 0) {
			if ($this->debug) {
				print "body="; var_dump($this->data);
			}
			curl_setopt($this->curl, CURLOPT_POST, $this->datalen);
			curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->data);
		}
  		$this->process($url);
		return $this->http_status;
	}


	public function read_function($curl, $fd, $length) {
		//print "reading... " . $length . "\n";
		$resp = null;
		if ($this->postdata != null) {
			if (strlen($this->postdata) <= $length) {
				$data = $this->postdata;
				$this->postdata = null;
				$resp = $data;
			} else {
				$data = substr($this->postdata, 0, $length);
				$this->postdata = substr($this->postdata, $length);
				$resp = $data;
			}

		} else {
			if ($this->eof) {
				$resp = null;
			}
			else if (feof($this->stream)) {
				$this->eof = true;
				$resp = "\n" . $this->boundary . "--\n";
			} else {
				$buffer = fread($this->stream, $length);
				if ($buffer != false) {
					$resp = $buffer;
				}
			}
		}
		//print "returning: " . $resp . "\n";
		print $resp;
		return $resp;
	}


	public function post_multipart($url, $name, $stream, $exists) {
		$bdry = dechex(time(0));
		$this->boundary = "--" . $bdry;
		$cd = "\n" . $this->boundary . "\nContent-Disposition: form-data; name=";
		$this->setup();
		$this->stream = $stream;
		$this->addHeader("Content-Type", "multipart/form-data; boundary=--" . $bdry);
		curl_setopt($this->curl, CURLOPT_URL, $url);
		curl_setopt($this->curl, CURLOPT_POST, 1);
		curl_setopt($this->curl, CURLOPT_READFUNCTION, array($this, 'read_function'));
		$this->postdata = $cd . '"exists"' . "\n\n" . $exists . "\n"; 
		$this->postdata .= $cd . '"file"; filename="' . $name . '"' . "\n"; 
		$this->postdata .= "Content-Type: application/octet-stream\n\n"; 
  		$this->process($url);
		return $this->http_status;
	}


	public function put($url) {
		$this->setup();
		$this->process($url);
		return $this->http_status;
	}


	public function get($url) {
		$this->setup();
		$this->process($url);
		return $this->http_status;
	}


	public function head($url) {
		$this->setup();
		$this->process($url);
		return $this->http_status;
	}


	public function delete($url) {
		$this->setup();
		curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		$this->process($url);
		return $this->http_status;
	}


	public function getResponse($json = false, $check = true) {
		if (!$this->is_raw && $json && $this->hasHeader('Accept', 'application/json')) {
			$res = json_decode($this->response, true);
			if ($check) {
				$b = new BitcasaStatus($res);
				$b->throw_on_failure();
			}
			return $res;
		}
		return $this->response;
	}

	public function setUserAgent($agent) {
		$this->user_agent = $agent;
	}

	public function getUserAgent() {
		return $this->user_agent;
	}

	private function process($url) {
		if (!$this->is_raw) {
			$this->addMissingHeader('Accept', 'application/json');
		}
		if ($this->return_xfer) {
			curl_setopt_array($this->curl, array(CURLOPT_RETURNTRANSFER => 1));
		}
		curl_setopt_array($this->curl, array(CURLOPT_URL => $url,
											 CURLOPT_FOLLOWLOCATION => true,
											 CURLOPT_SSL_VERIFYPEER => false,
											 CURLOPT_SSL_VERIFYHOST => 0));
		$hdrs = $this->getHeaders();
		if ($this->debug) {
			var_dump($hdrs);
			var_dump($url);
		}
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, $hdrs);

		//print "---------------------------------------------------\n";
		$resp = curl_exec($this->curl);
		//print "---------------------------------------------------\n";

		if ($resp != false) {
			$this->response = $resp;
		} else {
			$this->response = null;
		}
		
		$this->http_status = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
		if ($this->debug) {
			var_dump("HTTP status: " .	$this->http_status );
		}
		if ($resp == NULL || $resp == false) {
			$this->error_msg = curl_error($this->curl);
			$this->error_code = curl_errno($this->curl);
			if ($this->debug) {
				var_dump($this->error_msg);
			}
		} else {
			$this->response = $resp;
		}

		// Close request to clear up some resources
		curl_close($this->curl);
	}

	private function setup() {
		$this->curl = curl_init();
		$this->http_status = 0;
		$token = "Bearer " . $this->session->getAccessToken();
        $this->addMissingHeader("Authorization", $token);
		$this->addMissingHeader("Content-Type", "application/x-www-form-urlencoded; charset=\"utf-8\"");
		if ($this->user_agent != null) {
			curl_setopt($curl, CURLOPT_USERAGENT, 'http://testcURL.com');
		}
	}
}


?>
