<?php

/**
 * The user account related unit tests.
 */
class AccountTest extends BaseTest {

    /**
     * Test authentication.
     */
    public function testAuthenticate(){
        $this->getSession()->authenticate(self::USERNAME, self::PASSWORD);
        $this->assertTrue(true, $this->getSession()->isLinked());
    }

    /**
     * Test for retrieving account.
     */
    public function testAccount() {
        $session = $this->getSession();

        /**  @var \CloudFS\Session $session */
        $account = $session->account();

        /** @var \CloudFS\Account $account */
        $this->assertNotNull($account);
        $this->assertNotNull($account->getId());
        $this->assertNotNull($account->getStorageUsage());
        $this->assertNotNull($account->getOverStorageLimit());
        $this->assertNotNull($account->getStateId());
        $this->assertNotNull($account->getStateDisplayName());
        $this->assertNotNull($account->getPlanDisplayName());
        $this->assertNotNull($account->getPlanId());
        $this->assertNotNull($account->getAccountLocale());

    }

}