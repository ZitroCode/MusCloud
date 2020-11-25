<?php

class User {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getUser($email){
        $this->db->query("SELECT * FROM users WHERE Email=:email");
        $this->db->bind(':email', $email);
        return $this->db->resultGet(); 
    }
    
    public function getUsers() {
        $this->db->query("SELECT * FROM users");
        return $this->db->resultsGet();
    }

    public function addUser($data) {
        $this->db->query("INSERT INTO users (Name, Lastname, Email, Password, Username, Create_date) 
        VALUES (:name, :lastname, :email, :password, :username, :date)");
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':lastname', $data['lastname']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':date', date("Y-m-d H:i:s"));

        return ($this->db->run()) ? true : false;
    }

    public function veryEmail($email) {
        $this->db->query("SELECT * FROM users WHERE Email=:email LIMIT 1");
        $this->db->bind(':email', $email);
        return ($this->db->rowsGet() > 0) ? true : false;
    }

    public function editUser($id, $data) {

    }

    public function delete($id, $data) {

    }
    
}