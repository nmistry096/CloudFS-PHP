<?php

/**
 * The user related unit tests.
 */
class UserTest extends BaseTest {

    /**
     * Test authentication.
     */
    public function testAuthenticate() {
        $this->getSession()->authenticate(self::USERNAME, self::PASSWORD);
        $this->assertTrue(true, $this->getSession()->isLinked());
    }

    /**
     * Test for retrieving user profile.
     */
    public function testUserProfile() {
        $session = $this->getSession();

        /**  @var \CloudFS\Session $session */
        $user = $session->user();

        /** @var \CloudFS\User $user */
        $this->assertNotNull($user);
        $this->assertEquals(self::USERNAME, $user->getUsername());
    }

}