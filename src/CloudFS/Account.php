<?php

namespace CloudFS;

/**
 * Represents a bitcasa cloudfs account.
 * @package CloudFS
 */
class Account {

    private $id;
    private $storageUsage;
    private $storageLimit;
    private $overStorageLimit;
    private $stateDisplayName;
    private $stateId;
    private $planDisplayName;
    private $planId;
    private $sessionLocale;
    private $accountLocale;

    /**
     *  Retrieves the account id.
     *
     * @return The retrieved account id.
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Retrieves the storage amount used.
     *
     * @return The used storage amount.
     */
    public function getStorageUsage() {
        return $this->storageUsage;
    }

    /**
     * Retrieves the storage limit.
     *
     * @return The storage limit.
     */
    public function getStorageLimit() {
        return $this->storageLimit;
    }

    /**
     * Retrieves the OTL of account.
     *
     * @return The OTL.
     */
    public function getOverStorageLimit() {
        return $this->overStorageLimit;
    }

    /**
     * Retrieves the account state display name.
     *
     * @return The account state display name.
     */
    public function getStateDisplayName() {
        return $this->stateDisplayName;
    }

    /**
     * Retrieves the account state id.
     *
     * @return The account state id.
     */
    public function getStateId() {
        return $this->stateId;
    }

    /**
     * Retrieves the account plan display name.
     *
     * @return The account plan display name.
     */
    public function getPlanDisplayName() {
        return $this->planDisplayName;
    }

    /**
     * Retrieves the account plan id.
     *
     * @return The account plan id.
     */
    public function getPlanId() {
        return $this->planId;
    }

    /**
     * Retrieves the session locale.
     *
     * @return The session locale.
     */
    public function getSessionLocale() {
        return $this->sessionLocale;
    }

    /**
     * Retrieves the account locale.
     *
     * @return The account locale.
     */
    public function getAccountLocale() {
        return $this->accountLocale;
    }

    /**
     * The account construct.
     */
    private function __construct() {

    }

    /**
     * Retrieves an account instance from the supplied data.
     *
     * @param mixed $data The retrieved data.
     * @return An account instance.
     */
    public static function getInstance($data) {
        $account = new Account();
        $account->id = $data['result']['account_id'];
        $account->storageUsage = $data['result']['storage']['usage'];

        if(!empty($data['result']['storage']['limit']))
        {
            $account->storageLimit = $data['result']['storage']['limit'];
        }

        $account->overStorageLimit = $data['result']['storage']['otl'];
        $account->stateDisplayName = $data['result']['account_state']['display_name'];
        $account->stateId = $data['result']['account_state']['display_name'];
        $account->planDisplayName = $data['result']['account_plan']['display_name'];
        $account->planId = $data['result']['account_plan']['id'];

        if(!empty($data['result']['session']['locale'])) {
            $account->sessionLocale = $data['result']['session']['locale'];
        }

        $account->accountLocale = $data['result']['locale'];
        return $account;
    }

}