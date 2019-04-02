<?php
class User{
    private $id;
    private $name;
    private $username;
    private $password;
    private $email;
    private $privilege;

    public static $PRIVILEGE_TYPES = array('Manager','Tester','Developer');
    public static $PRIVILEGE_MANAGER   = 1;
    public static $PRIVILEGE_TESTER    = 2;
    public static $PRIVILEGE_DEVELOPER = 3;

    public function __construct($id = null, $name = null, $username = null, $password = null, $email = null, $privilege = null){
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->privilege = $privilege;
    }

    //Getters & Setters
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function getUsername(){
        return $this->username;
    }
    public function setUsername($username){
        $this->username = $username;
    }
    public function getPassword(){
        return $this->password;
    }
    public function setPassword($password){
        $this->password = $password;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function getPrivilege(){
        return $this->privilege;
    }
    public function setPrivilege($privilege){
        $this->privilege = $privilege;
    }
}