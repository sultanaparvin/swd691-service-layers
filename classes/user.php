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
        $sql = "SELECT * FROM `users`";
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
        $sql = "SELECT * FROM `users` WHERE `id`=".$id;
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res) > 0){ //Check to make item exist with this id
            $row = mysqli_fetch_object($res);
            $output = new User($row->id, $row->name, $row->username, $row->password, $row->email, $row->privilege);
        }
        return $output;
    }

    //Get all values as array . This helps to access to private properties
    public function getAllAsArray(){
        $output = array();
        $items = $this->getAll();
        if(count($items) > 0){ //Check to make sure table is not empty
            foreach($items as $item){
                $output[] = array(
                    'id' => $item->id,
                    'name' => $item->name,
                    'username' => $item->username,
                    'password' => $item->password,
                    'email' => $item->email,
                    'privilege' => $item->privilege
                );
            }
        }
        return $output;
    }

    //Get by id as array . This helps to access to private properties
    public function getByIdAsArray($id){
        $output = false;
        $item = $this->getById($id);
        if($item != false){ //Check to make item exist with this id
            $output = array(
                'id' => $item->id,
                'name' => $item->name,
                'username' => $item->username,
                'password' => $item->password,
                'email' => $item->email,
                'privilege' => $item->privilege
            );
        }
        return $output;
    }

    //Save function handle both insert and update.
    public function save(){
        global $conn;
        if($this->id === null){ //Insert
            $sql = "INSERT INTO `users` (`name`,`username`,`password`,`email`,`privilege`)VALUES('".$this->name."','".$this->username."','".$this->password."','".$this->email."','".$this->privilege."')";
            mysqli_query($conn,$sql);
            $this->id = mysqli_insert_id($conn);//Retrieve the auto inc id.
            return $this->id;
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

    //login method
    public static function login($username, $password){
        $output = false;
        global $conn;
        $sql = "SELECT * FROM `users` WHERE `username`='".$username."' AND `password`='".$password."'";
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res) == 1){ //Check to make sure only one user with this credentials exist
            $row = mysqli_fetch_object($res);
            $_SESSION['loggedin'] = true;
            $_SESSION['userid'] = $row->id;
            $_SESSION['privilege'] = $row->privilege;
            $output = true;
        }
        return $output;
    }

    //logout method
    public static function logout(){
        $output = false;
        unset($_SESSION['loggedin']);
        unset($_SESSION['userid']);
        unset($_SESSION['privilege']);
        $output = true;
        return $output;
    }

    //isAuthorized method check to see if user is authorized to access to an endpoint.
    //isAuthorized has one parameter and that is the required privilege for access to a sepesific endpoint(This is being provided by the endpoint)
    //required privilege is a comma seprated string containing various possible privileges
    public static function isAuthorized($requiredPrivilege){
        $privilegesArray = explode(',',$requiredPrivilege);
        $output = false;
        if(!empty($_SESSION['loggedin']) && $_SESSION['loggedin']==true &&!empty($_SESSION['privilege']) && in_array($_SESSION['privilege'],$privilegesArray) && !empty($_SESSION['userid'])){
            $output = true;
        }
        return $output;
    }

    //get information of current loggedin user
    public function getLoggedinUser(){
        $output = false;
        if(!empty($_SESSION['loggedin']) && !empty($_SESSION['userid']) && !empty($_SESSION['privilege'])){
            $User = new User();
            $output = $User->getByIdAsArray($_SESSION['userid']);
        }
        return $output;
    }

}