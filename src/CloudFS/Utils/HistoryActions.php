<?php
/**
 * Created by PhpStorm.
 * User: dhanushka
 * Date: 3/10/15
 * Time: 2:12 PM
 */

namespace CloudFS\Utils;


/**
 * Class HistoryActions
 */
class HistoryActions {

    /**
     * Specifies the history actions available for bitcasa.
     */
    const SHARE_RECEIVE = 1;
    const SHARE_CREATE = 2;
    const DEVICE_UPDATE = 3;
    const DEVICE_CREATE = 4;
    const DEVICE_DELETE = 5;
    const ALTER_META = 6;
    const COPY = 7;
    const MOVE = 8;
    const CREATE = 9;
    const DELETE = 10;
    const TRASH = 11;

    private $historyAction;

    /**
     * Initializes the history action instance.
     *
     * @param mixed $result The action result.
     */
    private function HistoryActions($result) {
        $this->historyAction = $result;
    }

    /**
     * Returns the history action according to the supplied string result.
     *
     * @param string $result The supplied string result.
     * @return The history action for the supplied string result.
     */
    public static function getResult($result) {
        if ($result == "share_receive")
            return SHARE_RECEIVE;
        else if ($result == "share_create")
            return SHARE_CREATE;
        else if ($result == "device_update")
            return DEVICE_UPDATE;
        else if ($result == "device_create")
            return DEVICE_CREATE;
        else if ($result == "device_delete")
            return DEVICE_DELETE;
        else if ($result == "alter_meta")
            return ALTER_META;
        else if ($result == "copy")
            return COPY;
        else if ($result == "move")
            return MOVE;
        else if ($result == "create")
            return CREATE;
        else if ($result == "delete")
            return DELETE;
        else if ($result == "trash")
            return TRASH;
        else
            return null;
    }
}