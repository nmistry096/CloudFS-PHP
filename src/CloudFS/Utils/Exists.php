<?php

namespace CloudFS\Utils;

/**
 * Class Exists
 * Specifies the action to perform if an item already exists.
 */
abstract class Exists {
    const FAIL = "fail";
    const OVERWRITE = "overwrite";
    const RENAME = "rename";
}