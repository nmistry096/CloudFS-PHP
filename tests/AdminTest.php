<?php

class AdminTest extends BaseTest {

    /**
     * Create bitcasa user account without admin credentials.
     */
    public function testCreateAccountWithoutAdminCredentials() {
        $requestFailed = false;
        try {
            $username = rand(1000000, 100000000);
            $password = rand(1000000, 100000000);
            $user = $this->getSession()->createAccount($username, $password);
        } catch (\Exception $exception) {
            $requestFailed = true;
        }

        $this->assertTrue($requestFailed);
    }

    /**
     * Create bitcasa user account.
     */
    public function testCreateAccount() {
        $username = rand(1000000, 100000000);
        $password = rand(1000000, 100000000);
        /** @var \CloudFS\User $user */
        if (strpos($this::ADMIN_ID, "add cloudfs admin") == False and !empty($this::ADMIN_ID)) {
            $this->getSession()->setAdminCredentials($this::ADMIN_ID, $this::ADMIN_SECRET);
            $user = $this->getSession()->createAccount($username, $password);
            $this->assertNotNull($user);
            $this->assertEquals($username, $user->getUsername());
        }
    }
}