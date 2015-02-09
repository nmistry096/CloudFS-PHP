<?php

/**
 * Bitcasa Client PHP SDK
 * Copyright (C) 2014 Bitcasa, Inc.
 *
 * This file contains an SDK in PHP for accessing the Bitcasa infinite drive.
 *
 * For support, please send email to support@bitcasa.com.
 */


class BitcasaStatus {

	private $status;
	private $message;
	private $code;
	private $response;

	public function __construct($response) {
		$this->response = $response;
		$this->status = isset($response["result"]) && $response["result"] != null && $response["result"] != false;
		$this->code = 0;
		$message = isset($response["error"]) && isset($response["error"]["message"])
			? $response["result"]["message"] : "";
		$this->code = isset($response["error"]) && isset($response["error"]["code"])
			? $response["result"]["code"] : 0;
		$this->message = $message;
	}


	public function error_code() {
		return $this->code;
	}


	public function error_message() {
		return $this->message;
	}


	public function success()
	{
		return $this->status;
	}

	public function throw_on_failure() {
		if (!$this->success()) {
			if (getenv("BC_DEBUG") != null) {
				var_dump($this->response);
				print "BitcasaError: " . $this->code . " => " . $this->message . "\n";
			}
			throw new BitcasaError($this);
		}
	}

}


class BitcasaError extends Exception {

	private $status;

	public function __construct($status) {
		$this->status = $status;
		parent::__construct($status->error_message());
	}

	public function get_status() {
		return $this->status;
	}
}


class NotImplemented extends Exception {
}

class OperationNotSupported extends Exception {
}

class MethodNotSupported extends Exception {
}

class InvalidArgument extends Exception {

	public function __construct($argno) {
		parent::__construct($argno > 0 ? "Invalid value for argument number " . $argno
							: "Invalid argument type");
	}

}


function assert_non_null($s, $argno = 0) {
	if ($s == null) {
		throw new InvalidArgument($argno) ;
	}
	return true;
}


function assert_string($s, $argno = 0) {
	if (! is_string($s)) {
		throw new InvalidArgument($argno) ;
	}
	return true;
}


function assert_string_or_null($s, $argno = 0) {
	if ($s != null &&!is_string($s)) {
		throw new InvalidArgument($argno) ;
	}
	return true;
}


function assert_number($s, $argno = 0) {
	if (! is_number($s)) {
		throw new InvalidArgument($argno) ;
	}
	return true;
}


// TODO: needs more work!
function assert_path($s, $argno = 0) {
	if (is_string($s)) {
		if ($s == "/") {
			return true;
		}
		$c = explode("/", $s);
		if ($c[0] == "" && count($c) > 0) {
			return true;
		}
	}
	throw new InvalidArgument($argno) ;
}



?>
