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
     *  Retrieves the user email
     *
     * @return The user email.
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Retrieves the users first name.
     *
     * @return The users first name.
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * Retrieves the users last name.
     *
     * @return The users last name.
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * Retrieves the user id.
     *
     * @return The user id.
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Retrieves the users user name.
     *
     * @return The users username.
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Retrieves the users last login timestamp.
     *
     * @return The users last login timestamp.
     */
    public function getLastLogin() {
        return $this->lastLogin;
    }

    /**
     * Retrieves the user created timestamp.
     *
     * @return The user created timestamp.
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Private constructor to avoid creating new share objects.
     */
    private function __construct() {

    }

    /**
     * Retrieves a user instance from the supplied result.
     *
     * @param mixed $data The json response retrieved from rest api.
     * @return A user instance.
     */
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