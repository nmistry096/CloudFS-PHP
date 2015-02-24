<?php

/**
 * The base unit test.
 */
class BaseTest extends PHPUnit_Framework_TestCase {

    /**
     * The bitcasa account related credential information.
     */
    const CLIENT_ID = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
    const CLIENT_SECRET = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
    const END_POINT = 'xxxxxxxxx.cloudfs.io';
    const USERNAME = 'test@test.com';
    const PASSWORD = 'xxxxxx';

    /**
     * The session variable of the unit test.
     */
    private static $session;

    /**
     * Executed before executing all the tests.
     * Sets the session up.
     */
    public static function setUpBeforeClass() {
        self::$session = new Session(self::END_POINT, self::CLIENT_ID, self::CLIENT_SECRET);
    }

    /**
     * Executed after executing all the tests.
     */
    public static function tearDownAfterClass() {
        self::$session = NULL;
    }

    /**
     * Retrieves the session object.
     *
     * @return The session object.
     */
    protected function getSession() {
        return self::$session;
    }

    /**
     * Retrieves the path given an associative array.
     *
     * @param mixed $item The item path string or array.
     * @param string $parent_path The parent item path.
     * @return The processed path.
     */
    protected function getPathFromAssociativeArray($item = null, $parent_path = null) {
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

    /**
     * Retrieves the path of an item.
     *
     * @param mixed $item The item path string or an item instance.
     * @param string $parent_path The parent path string.
     * @return The processes path.
     */
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
                $path .= $item->id();
            }
        }

        return $path;
    }

    /**
     * Retrieves an item from a given item associative array.
     *
     * @param array $items The associative array containing items.
     * @param string $item_name The name of the item to be retrieved.
     * @return The retrieved item.
     */
    protected function getItemFromAssociativeArray(array $items, $item_name) {
        $result = null;
        foreach($items['result']['items'] as $item) {
            if ($item['name'] == $item_name) {
                $result = $item;
                break;
            }
        }

        return $result;
    }

    /**
     * Retrieves an item from a given item array.
     *
     * @param array $items The array containing items.
     * @param $item_name The name of the item to be retrieved.
     * @return The retrieved item.
     */
    protected function getItemFromIndexArray(array $items, $item_name) {
        $result = null;
        foreach($items as $item) {
            if ($item->name() == $item_name) {
                $result = $item;
                break;
            }
        }

        return $result;
    }

}