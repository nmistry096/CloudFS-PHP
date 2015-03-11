<?php
/**
 * Created by PhpStorm.
 * User: dhanushka
 * Date: 3/10/15
 * Time: 2:12 PM
 */

namespace CloudFS\Utils;


/**
 * Class RestoreMethod
 * Specifies the action to perform if the same file exists in the restore destination.
 */
abstract class RestoreMethod {
    const FAIL = 1;
    const RESCUE = 2;
    const RECREATE = 3;
}