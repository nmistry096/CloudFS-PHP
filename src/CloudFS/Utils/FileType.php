<?php
/**
 * Created by PhpStorm.
 * User: dhanushka
 * Date: 3/10/15
 * Time: 2:13 PM
 */

namespace CloudFS\Utils;


/**
 * Class FileType
 * Specifies the file types available in the bitcasa cloud.
 */
abstract class FileType {
    const FILE = "file";
    const FOLDER = "folder";
    const MIRROR_FOLDER = "mirror_folder";
    const ROOT = "root";
    const METAFOLDER = "metafolder";
}