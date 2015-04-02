<?php

namespace CloudFS\Utils;

/**
 * Class RestoreMethod
 * Specifies the action to perform if the same file exists in the restore destination.
 */
abstract class RestoreMethod {
    const FAIL = 'fail';
    const RESCUE = 'rescue';
    const RECREATE = 'recreate';
}