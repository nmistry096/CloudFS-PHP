<?php

require __DIR__ . '/../vendor/autoload.php';

class SessionTest extends BaseTest{

    public function testAuthentication() {
        $this->getSession()->authenticate(self::USERNAME, self::PASSWORD);
        $this->assertTrue(true, $this->getSession()->isLinked());
    }

    public function testAccessToken() {
        $token = $this->getSession()->getAccessToken();
        $this->assertNotNull($token, "Access token is null");
        $this->assertNotEmpty($token, "Access token is empty");
    }

    public function testUnlink() {
        $this->getSession()->unlink();
        $this->assertFalse(false, $this->getSession()->isLinked());
    }

}