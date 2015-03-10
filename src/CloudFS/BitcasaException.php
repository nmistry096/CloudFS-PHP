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
 * Check if a supplied argument in null or not.
 *
 * @param mixed $s The argument to validate.
 * @param int $argno The argument number to pass to InvalidArgument.
 * @return bool The null status of the argument supplied.
 * @throws InvalidArgument
 */
function assert_non_null($s, $argno = 0) {
	if ($s == null) {
		throw new \InvalidArgument($argno) ;
	}
	return true;
}

/**
 * Check if a supplied argument is of type string or not.
 *
 * @param mixed $s The argument to validate.
 * @param int $argno The argument number to pass to InvalidArgument.
 * @return bool The string  status of the argument supplied.
 * @throws InvalidArgument
 */
function assert_string($s, $argno = 0) {
	if (! is_string($s)) {
		throw new \InvalidArgument($argno) ;
	}
	return true;
}

/**
 * Check if a supplied argument is null or of type string.
 *
 * @param mixed $s The argument to validate.
 * @param int $argno The argument number to pass to InvalidateArgument.
 * @return bool The string or null status of the argument supplied.
 * @throws InvalidArgument
 */
function assert_string_or_null($s, $argno = 0) {
	if ($s != null &&!is_string($s)) {
		throw new \InvalidArgument($argno) ;
	}
	return true;
}

/**
 * Check if a supplied argument is a number or not.
 *
 * @param mixed $s The argument to validate.
 * @param int $argno The argument number to pass to InvalidateArgument.
 * @return bool The number status of the argument supplied.
 * @throws InvalidArgument
 */
function assert_number($s, $argno = 0) {
	if (! is_number($s)) {
		throw new \InvalidArgument($argno) ;
	}
	return true;
}

/**
 * Check if a supplied argument is a path or not.
 *
 * @param mixed $s The argument to validate.
 * @param int $argno The argument number to pass to InvalidateArgument.
 * @return bool The path status of the argument supplied.
 * @throws InvalidArgument
 */
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
	throw new \InvalidArgument($argno) ;
}



?>
