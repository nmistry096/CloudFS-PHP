<?php

use CloudFS\Session;

/**
 * The base unit test.
 */
class BaseTest extends PHPUnit_Framework_TestCase {

    /**
     * The bitcasa account related credential information.
     */
    const CLIENT_ID = '6VaRUN0AJDftZaaFyQy98oHvVmuUjI8fJz6UHIkQct0';
    const CLIENT_SECRET = 'fSXNM3HhRJaNM-N8gJsADjYwxvQnCMyZEh95BQpjuNRpt2j5EGVInd8UtTbmjg8dtd1qK0sb1NDmN7ClxxdanA';
    const END_POINT = 'evyg9ym7w1.cloudfs.io';
    const USERNAME = 'gayan@calcey.com';
    const PASSWORD = 'user@123';
    const ADMIN_ID = 'lO8YWMqr6SLlPztLI7JiPDM-yQuosvlvLiCA_2vzdf0';
    const ADMIN_SECRET = 'eIdbCSpAawBmyzCcdb5c1htZqyeCeim13cFJb1knGlQ2MjZ8AGWcBrTanTlJnNyDcPdDTPBgGK9znF0HnvjRpw';


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

}
