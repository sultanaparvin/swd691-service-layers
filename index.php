<?php 
    require_once('config.php');
    //Set default values
    $output = array(
        'success' => false,
        'message' => 'Error! Wrong parameters.'
    );
    $action = '';
    $subaction = '';
    $id = null;

    //Get action,subaction and id either from GET or POST
    if(!empty($_GET['action'])){
        $action = $_GET['action'];
    }
    if(!empty($_POST['action'])){
        $action = $_POST['action'];
    }
    if(!empty($_GET['subaction'])){
        $subaction = $_GET['subaction'];
    }
    if(!empty($_POST['subaction'])){
        $subaction = $_POST['subaction'];
    }
    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }
    if(!empty($POST['id'])){
        $id = $POST['id'];
    }

    //Instantiate all classes
    $User = new User();

    //API If statement
    if($action === 'users'){
        // ******************************************* Get all users
        if($subaction === 'getall'){ 
            $items = $User->getAllAsArray();
            if(count($items) > 0){
                $output = array(
                    'success' => true,
                    'message' => '',
                    'items' => $items,
                );
            }else{
                $output = array(
                    'success' => false,
                    'message' => 'There is no user in the database.',
                );
            }
        }
        // ******************************************* Get user by id
        if($subaction === 'getbyid'){ 
            if(is_numeric($id)){ // Check to make sure the id is numeric value
                $item = $User->getByIdAsArray($id);
                if($item !== false){
                    $output = array(
                        'success' => true,
                        'message' => '',
                        'item' => $item,
                    );
                }else{
                    $output = array(
                        'success' => false,
                        'message' => 'Please provide a valid ID. No user exist with the provided ID.',
                    );
                }
            }
        }
        // ******************************************* Add new user
        if($subaction === 'add'){
            $errors = array();
            if(!empty($_POST['name'])){
                $name = $_POST['name'];
            }else{
                $errors[] = 'Please provide your name.';
            }
            if(!empty($_POST['username'])){
                $username = $_POST['username'];
            }else{
                $errors[] = 'You need to select a username.';
            }
            if(!empty($_POST['password'])){
                $password = $_POST['password'];
            }else{
                $errors[] = 'Please select a password.';
            }
            if(!empty($_POST['email'])){
                $email = $_POST['email'];
            }else{
                $errors[] = 'Please provide your email address.';
            }
            if(!empty($_POST['privilege'])){
                $privilege = $_POST['privilege'];
            }else{
                $errors[] = 'Please select a privilege level.';
            }
            $hashedPassword = sha1($password); // Encrypt the password using SHA1
            $User->setName($name);
            $User->setUsername($username);
            $User->setPassword($hashedPassword);
            $User->setEmail($email);
            $User->setPrivilege($privilege);
            if(count($errors)==0){
                $newItemId = $user->save();
                $output = array(
                    'success' => true,
                    'message' => 'The new user has been successfully added.',
                    'id' => $newItemId,
                );
            }else{
                $output = array(
                    'success' => false,
                    'message' => $errors
                );
            }
        }
        // ******************************************* Edit user
        if($subaction === 'edit'){
            $User = $User->getById($id);
            $errors = array();
            if($User === false){
                $error[] = 'There is no user with provided id.';
            }
            if(!empty($_POST['name'])){
                $name = $_POST['name'];
            }else{
                $errors[] = 'Please provide your name.';
            }
            if(!empty($_POST['username'])){
                $username = $_POST['username'];
            }else{
                $errors[] = 'You need to select a username.';
            }
            if(!empty($_POST['email'])){
                $email = $_POST['email'];
            }else{
                $errors[] = 'Please provide your email address.';
            }
            if(!empty($_POST['privilege'])){
                $privilege = $_POST['privilege'];
            }else{
                $errors[] = 'Please select a privilege level.';
            }
            if(!empty($_POST['password'])){ // If password has not been provided, don't update the password
                $password = $_POST['password'];
                $hashedPassword = sha1($password); // Encrypt the password using SHA1
                $User->setPassword($hashedPassword);
            }
            $User->setName($name);
            $User->setUsername($username);
            $User->setEmail($email);
            $User->setPrivilege($privilege);
            if(count($errors)==0){
                $newItemId = $user->save();
                $output = array(
                    'success' => true,
                    'message' => 'The user has been successfully updated.'
                );
            }else{
                $output = array(
                    'success' => false,
                    'message' => $errors
                );
            }
        }
        
        // ******************************************* Delete user
        if($subaction === 'add'){
            $User = $User->getById($id);
            $errors = array();
            if($User === false){
                $error[] = 'There is no user with provided id.';
            }
            if(count($errors)==0){
                $newItemId = $user->delete();
                $output = array(
                    'success' => true,
                    'message' => 'The user has been successfully deleted.'
                );
            }else{
                $output = array(
                    'success' => false,
                    'message' => $errors
                );
            }
        }
    }else if($action === 'projects'){

    }else if($action === 'testcase'){

    }else if($action === 'comments'){

    }

    //Convert the output array to json and print on the screen
    echo(json_encode($output));
?>