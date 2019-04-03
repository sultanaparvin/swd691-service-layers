<?php
class User{
    private $id;
    private $name;
    private $username;
    private $password;
    private $email;
    private $privilege;

    //Privilege types
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

    //Get all the users
    public function getAll(){
        $output = array();
        global $conn;
        $sql = "SELECT * FROM users";
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res) > 0){ //Check to make sure table is not empty
            while($row = mysqli_fetch_object($res)){
                $output[] = new User($row->id, $row->name, $row->username, $row->password, $row->email, $row->privilege);
            }
        }
        return $output;
    }

    //Get a user by id
    public function getById($id){
        $output = false;
        global $conn;
        $sql = "SELECT * FROM users WHERE `id`=".$id;
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res) > 0){ //Check to make sure table is not empty
            $output = new User($row->id, $row->name, $row->username, $row->password, $row->email, $row->privilege);
        }
        return $output;
    }

    //Save function handle both insert and update.
    public function save(){
        global $conn;
        if($this->id === null){ //Insert
            $sql = "INSERT INTO `users` (`name`,`username`,`password`,`email`,`privilege`)VALUES('".$this->name."','".$this->username."','".$this->password."','".$this->email."','".$this->privilege."')";
            mysqli_query($conn,$sql);
        }else{ //Update
            $sql = "UPDATE `users` SET `name`='".$this->name."', `username`='".$this->username."' ,`password`='".$this->password."' ,`email`='".$this->email."' ,`privilege`='".$this->privilege."' WHERE `id`=".$this->id;
            mysqli_query($conn,$sql);
        }
    }

    //Delete function removes a user
    public function delete(){
        global $conn;
        $sql = "DELETE FROM `users` WHERE `id`=".$this->id;
        mysqli_query($conn,$sql);
    }
}