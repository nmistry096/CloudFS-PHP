<?php

class AdminTest extends BaseTest {

    private $username = 'dhanushka@calcey.com';
    private $password = 'dhanushka';

    public function testCreateAccount() {
        $user = $this->getSession()->createAccount($this->username, $this->password);
    }

}