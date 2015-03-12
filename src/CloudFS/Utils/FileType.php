<?php

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