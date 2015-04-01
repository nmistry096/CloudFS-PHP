<?php

use CloudFS\Session;

/**
 * The base unit test.
 */
class BaseTest extends PHPUnit_Framework_TestCase {

    /**
     * The bitcasa account related credential information.
     */
    const CLIENT_ID = '<add client id here>';
    const CLIENT_SECRET = '<add client secret here>';
    const END_POINT = '<add cloudfs endpoint here>';
    const USERNAME = '<add cloudfs username here>';
    const PASSWORD = '<add cloudfs password here>';
    const ADMIN_ID = '<add cloudfs admin id here - only available for paid users>';
    const ADMIN_SECRET = '<add cloudfs admin secret here - only available for paid users>';

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
     * Retrieves an item from a given item array.
     *
     * @param array $items The array containing items.
     * @param string $item_name The name of the item to be retrieved.
     * @return \CloudFS\Item An item instance.
     */
    protected function getItem(array $items, $item_name) {
        $result = null;
        foreach ($items as $item) {
            /** @var \CloudFS\Item $item */
            if ($item->getName() == $item_name) {
                $result = $item;
                break;
            }
        }

        return $result;
    }

    protected function checkedAndCreateDirName($pathToDirector) {
        if (!file_exists($pathToDirector)) {
            mkdir($pathToDirector, 0777, true);
        }
    }

    /**
     * Retrieves the path given an associative array.
     *
     * @param mixed $item The item path string or array.
     * @param string $parent_path The parent item path.
     * @return The processed path.
     */
    protected function getPathFromAssociativeArray($item = null, $parent_path = null)
    {
        if ($parent_path == null) {
            $path = '/';
        } else {
            $path = $parent_path . '/';
        }

        if ($item != null) {
            if (is_string($item)) {
                $path .= $item;
            } else {
                $path .= $item['id'];
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
    protected function getItemFromAssociativeArray(array $items, $item_name)
    {
        $result = null;
        foreach ($items['result']['items'] as $item) {
            if ($item['name'] == $item_name) {
                $result = $item;
                break;
            }
        }

        return $result;
    }
}
