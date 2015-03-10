<?php
/**
 * Created by PhpStorm.
 * User: dhanushka
 * Date: 3/10/15
 * Time: 2:10 PM
 */

namespace CloudFS\Utils;


/**
 * Class FileOperation
 * Specifies the allowed file operations.
 */
abstract class FileOperation {
    const DELETE = 1;
    const COPY = 2;
    const MOVE = 3;
    const ADDFOLDER = 4;
    const ALTERMETA = 5;
    const META = 6;
}