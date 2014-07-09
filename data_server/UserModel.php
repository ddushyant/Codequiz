<?php

class UserModel {

    /*
        Get a single user from datastore
    */
    public getUser($id)  {}
    public getUsers($ids) {}
    public authUser($username,$password) {}
}

class User {
    private $_id;
    private $_name;
    private $_email;
    private $account_type;

    public function __construct() {
        // logic
    }

    public toJSON() {
        $json_rep = "{";
        $json_rep .= '"id":"' . string($_id) . '
    }
};

?>
