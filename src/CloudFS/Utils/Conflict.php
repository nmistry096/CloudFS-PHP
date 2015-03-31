<?php

namespace CloudFS\Utils;

/**
 * Class Exists
 * Specifies the action to perform if an item already exists.
 */
abstract class Conflict {
    const FAIL = "fail";
    const IGNORE = "ignore";
}