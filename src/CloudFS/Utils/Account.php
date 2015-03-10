<?php

namespace CloudFS;

/**
 * Represents a bitcasa cloudfs user.
 * @package CloudFS
 */
class Account {

    private $id;
    private $storageUsage;
    private $storageLimit;
    private $oTL;
    private $accountStateDisplayName;
    private $accountPlanId;
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
    public function getOTL() {
        return $this->oTL;
    }

    /**
     * Retrieves the account state display name.
     *
     * @return The account state display name.
     */
    public function getAccountStateDisplayName() {
        return $this->accountStateDisplayName;
    }

    /**
     * Retrieves the account plan id.
     *
     * @return The account plan id.
     */
    public function getAccountPlanId() {
        return $this->accountPlanId;
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
     * Retrieves the processed account data.
     *
     * @param mixed $data The retrieved data.
     * @return The processed account data.
     */
    public static function getInstance($data) {
        $account = new Account();
        $account->id = $data['result']['account_id'];
        $account->storageUsage = $data['storage']['usage'];
        $account->storageLimit = $data['storage']['limit'];         //To be verified with REST
        $account->oTL = $data['storage']['otl'];
        $account->accountStateDisplayName = $data['account_plan']['display_name'];
        $account->accountPlanId = $data['account_plan']['id'];
        $account->sessionLocale = $data['session']['locale'];       //To be verified with REST
        $account->accountLocale = $data['account']['locale'];       //To be verified with REST
        return $account;
    }

}