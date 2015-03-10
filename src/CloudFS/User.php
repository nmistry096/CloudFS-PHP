<?php

namespace CloudFS;

/**
 * Represents a bitcasa cloudfs user.
 * @package CloudFS
 */
class User {

    private $email;
    private $firstName;
    private $lastName;
    private $id;
    private $username;
    private $lastLogin;
    private $createdAt;

    /**
     *  Retrieves the email
     *
     * @return Retrieves the email.
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @return string The first name.
     */
    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getLastLogin() {
        return $this->lastLogin;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    private function __construct() {

    }

    public static function getInstance($data) {
        $user = new User();
        $user->email = $data['result']['email'];
        $user->firstName = $data['result']['first_name'];
        $user->lastName = $data['result']['last_name'];
        $user->id = $data['result']['id'];
        $user->username = $data['result']['username'];
        $user->lastLogin = $data['result']['last_login'];
        $user->createdAt = $data['result']['created_at'];
        return $user;
    }

}