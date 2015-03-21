<?php

class AdminTest extends BaseTest {

    /**
     * Create bitcasa user account without admin credentials.
     */
    public function testCreateAccountWithoutAdminCredentials() {
        $failed = false;
        try {
            $username = rand(1000000, 100000000);
            $password = rand(1000000, 100000000);
            $user = $this->getSession()->createAccount($username, $password);
        } catch (\Exception $exception) {
            $failed = true;
        }

        $this->assertTrue($failed);
    }

    /**
     * Create bitcasa user account.
     */
    public function testCreateAccount() {
        $username = rand(1000000, 100000000);
        $password = rand(1000000, 100000000);
        /** @var \CloudFS\User $user */
        $this->getSession()->setAdminCredentials($this::ADMIN_ID, $this::ADMIN_SECRET);
        $user = $this->getSession()->createAccount($username, $password);
        $this->assertNotNull($user);
        $this->assertEquals($username, $user->getUsername());
    }
}