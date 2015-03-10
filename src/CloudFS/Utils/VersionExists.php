<?php
/**
 * Created by PhpStorm.
 * User: dhanushka
 * Date: 3/10/15
 * Time: 2:11 PM
 */

namespace CloudFS\Utils;


/**
 * Class VersionExists
 * Specifies the action to perform if the same version exists in a file.
 */
abstract class VersionExists {
    const FAIL = 1;
    const IGNORE = 2;
}