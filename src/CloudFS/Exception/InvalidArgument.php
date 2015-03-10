<?php
/**
 * Created by PhpStorm.
 * User: dhanushka
 * Date: 3/10/15
 * Time: 1:57 PM
 */

namespace CloudFS\Exception;


class InvalidArgument extends \Exception {

    /**
     * Initializes an instance of Invalid Argument.
     *
     * @param string $argno The argument supplied.
     */
    public function __construct($argno) {
        parent::__construct($argno > 0 ? "Invalid value for argument number " . $argno
            : "Invalid argument type");
    }

}