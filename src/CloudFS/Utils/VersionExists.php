<?php

namespace CloudFS\Utils;

/**
 * Class VersionExists
 * Specifies the action to perform if the same version exists in a file.
 */
abstract class VersionExists {
    const FAIL = 1;
    const IGNORE = 2;
}