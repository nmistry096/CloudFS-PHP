<?php
/**
 * Created by PhpStorm.
 * User: dhanushka
 * Date: 3/10/15
 * Time: 2:11 PM
 */

namespace CloudFS\Utils;


/**
 * Class Exists
 * Specifies the action to perform if an item already exists.
 */
abstract class Exists {
    const FAIL = "fail";
    const OVERWRITE = "overwrite";
    const RENAME = "rename";
    const REUSE = "reuse";
}