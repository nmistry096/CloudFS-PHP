<?php

class BaseTest extends PHPUnit_Framework_TestCase {

    const CLIENT_ID = 'k-O8NxC69MIlTe1vnCpemIMQe5B3LwCk73iGXGH-hwI';
    const CLIENT_SECRET = 'Ka7F-bNlnR7ODiqhF4T2P6Cm8fWE0_yRKI6GaT_MTwXIEww7Pkpv-DnAHvFcukr6NR25wp5hxic7M4sy5X9ksA';
    const END_POINT = 'm1qfb0fwlz.cloudfs.io';
    const USERNAME = 'dilshan@calcey.com';
    const PASSWORD = 'dilshan';

    private static $session;

    public static function setUpBeforeClass() {
        self::$session = new Session(self::END_POINT, self::CLIENT_ID, self::CLIENT_SECRET);
    }

    public static function tearDownAfterClass() {
        self::$session = NULL;
    }

    protected function getSession() {
        return self::$session;
    }

    protected function getPath($item = null, $parent_path = null) {
        if ($parent_path == null) {
            $path = '/';
        }
        else {
            $path = $parent_path . '/';
        }

        if ($item != null) {
            if (is_string($item)) {
                $path .= $item;
            }
            else {
                $path .= $item['id'];
            }
        }

        return $path;
    }

    protected function getItem(array $items, $item_name) {
        $result = null;
        foreach($items['result']['items'] as $item) {
            if ($item['name'] == $item_name) {
                $result = $item;
                break;
            }
        }

        return $result;
    }

}