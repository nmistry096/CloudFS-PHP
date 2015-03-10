<?php
/**
 * Created by PhpStorm.
 * User: dhanushka
 * Date: 3/10/15
 * Time: 2:11 PM
 */

namespace CloudFS\Utils;


/**
 * Class ApiMethod
 * Specifies the api methods available in bitcasa api.
 */
abstract class ApiMethod {
    const GENERAL = 1;
    const ACCOUNT = 2;
    const GETLIST = 3;
    const ADD_FOLDER = 4;
    const DELETE = 5;
    const COPY = 6;
    const MOVE = 7;
    const META = 8;
    const LISTSHARE = 9;
    const SHARE = 10;
    const BROWSE_SHARE = 11;
    const LISTHISTORY = 12;
    const LIST_FILE_VERSIONS = 13;
    const LIST_SINGLE_FILE_VERSION = 14;
    const PROMOTE_FILE_VERSION = 15;
    const UPLOAD = 16;
    const CREATE_TEST_USER_ACCOUNT = 17;
    const RECEIVE_SHARE = 18;
}