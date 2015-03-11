<?php

/**
 * Test Bitcasa session related functionality.
 */
class SessionTest extends BaseTest{

    /**
     * The session authenticate test.
     */
    public function testAuthentication() {
        $this->getSession()->authenticate(self::USERNAME, self::PASSWORD);
        $this->assertTrue(true, $this->getSession()->isLinked());
    }

    /**
     * The session access token test.
     */
    public function testAccessToken() {
        $token = $this->getSession()->getAccessToken();
        $this->assertNotNull($token, "Access token is null");
        $this->assertNotEmpty($token, "Access token is empty");
    }

    /**
     * Retrieve action history.
     */
    public function testActionHistory() {
        $actionHistory = $this->getSession()->actionHistory();
        $this->assertNotNull($actionHistory);
        $this->assertTrue(count($actionHistory['result']) > 0);
    }

    /**
     * The session unlink test.
     */
    public function testUnlink() {
        $this->getSession()->unlink();
        $this->assertFalse(false, $this->getSession()->isLinked());
    }

}