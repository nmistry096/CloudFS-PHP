<?php

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