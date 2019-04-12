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
    if(!empty($_POST['id'])){
        $id = $_POST['id'];
    }

    //Instantiate all classes
    $User = new User();
    $Project = new Project();
    $Comment = new Comment();

    //API If statement
    if($action === 'users'){
        // ******************************************* Get all privileges
        if($subaction === 'getAllPrivileges'){ 
            $output = array(
                'success' => true,
                'message' => '',
                'items' => User::$PRIVILEGE_TYPES,
            );
        }
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
            if(count($errors)==0){
                $hashedPassword = sha1($password); // Encrypt the password using SHA1
                $User->setName($name);
                $User->setUsername($username);
                $User->setPassword($hashedPassword);
                $User->setEmail($email);
                $User->setPrivilege($privilege);
                $newItemId = $User->save();
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
            if(count($errors)==0){
                if(!empty($_POST['password'])){ // If password has not been provided, don't update the password
                    $password = $_POST['password'];
                    $hashedPassword = sha1($password); // Encrypt the password using SHA1
                    $User->setPassword($hashedPassword);
                }
                $User->setName($name);
                $User->setUsername($username);
                $User->setEmail($email);
                $User->setPrivilege($privilege);
                $newItemId = $User->save();
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
        if($subaction === 'delete'){
            $User = $User->getById($id);
            $errors = array();
            if($User === false){
                $error[] = 'There is no user with provided id.';
            }
            if(count($errors)==0){
                $User->delete();
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
        // ******************************************* Get all projects
        if($subaction === 'getall'){ 
            $items = $Project->getAllAsArray();
            if(count($items) > 0){
                $output = array(
                    'success' => true,
                    'message' => '',
                    'items' => $items,
                );
            }else{
                $output = array(
                    'success' => false,
                    'message' => 'There is no project in the database.',
                );
            }
        }
        // ******************************************* Get project by id
        if($subaction === 'getbyid'){ 
            if(is_numeric($id)){ // Check to make sure the id is numeric value
                $item = $Project->getByIdAsArray($id);
                if($item !== false){
                    $output = array(
                        'success' => true,
                        'message' => '',
                        'item' => $item,
                    );
                }else{
                    $output = array(
                        'success' => false,
                        'message' => 'Please provide a valid ID. No project exist with the provided ID.',
                    );
                }
            }
        }
        // ******************************************* Add new project
        if($subaction === 'add'){
            $errors = array();
            if(!empty($_POST['name'])){
                $name = $_POST['name'];
            }else{
                $errors[] = 'Please provide the project name.';
            }
            if(!empty($_POST['description'])){
                $description = $_POST['description'];
            }else{
                $errors[] = 'Please provide the project description.';
            }
            if(count($errors)==0){
                $Project->setName($name);
                $Project->setDescription($description);
                $newItemId = $Project->save();
                $output = array(
                    'success' => true,
                    'message' => 'The new project has been successfully added.',
                    'id' => $newItemId,
                );
            }else{
                $output = array(
                    'success' => false,
                    'message' => $errors
                );
            }
        }
        // ******************************************* Edit project
        if($subaction === 'edit'){
            $Project = $Project->getById($id);
            $errors = array();
            if($Project === false){
                $error[] = 'There is no project with provided id.';
            }
            if(!empty($_POST['name'])){
                $name = $_POST['name'];
            }else{
                $errors[] = 'Please provide the project name.';
            }
            if(!empty($_POST['description'])){
                $description = $_POST['description'];
            }else{
                $errors[] = 'Please provide the project description.';
            }
            if(count($errors)==0){
                $Project->setName($name);
                $Project->setDescription($description);
                $Project->save();
                $output = array(
                    'success' => true,
                    'message' => 'The project has been successfully updated.'
                );
            }else{
                $output = array(
                    'success' => false,
                    'message' => $errors
                );
            }
        }
        
        // ******************************************* Delete project
        if($subaction === 'delete'){
            $Project = $Project->getById($id);
            $errors = array();
            if($Project === false){
                $error[] = 'There is no project with provided id.';
            }
            if(count($errors)==0){
                $Project->delete();
                $output = array(
                    'success' => true,
                    'message' => 'The project has been successfully deleted.'
                );
            }else{
                $output = array(
                    'success' => false,
                    'message' => $errors
                );
            }
        }
    }else if($action === 'testcase'){
    
    }else if($action === 'comments'){
        // ******************************************* Get all comments
        if($subaction === 'getall'){ 
            $items = $Comment->getAllAsArray();
            if(count($items) > 0){
                $output = array(
                    'success' => true,
                    'message' => '',
                    'items' => $items,
                );
            }else{
                $output = array(
                    'success' => false,
                    'message' => 'There is no comments in the database.',
                );
            }
        }
        // ******************************************* Get comment by id
        if($subaction === 'getbyid'){ 
            if(is_numeric($id)){ // Check to make sure the id is numeric value
                $item = $Comment->getByIdAsArray($id);
                if($item !== false){
                    $output = array(
                        'success' => true,
                        'message' => '',
                        'item' => $item,
                    );
                }else{
                    $output = array(
                        'success' => false,
                        'message' => 'Please provide a valid ID. No comment exist with the provided ID.',
                    );
                }
            }
        }
        // ******************************************* Add new comment
        if($subaction === 'add'){
            $errors = array();
            if(!empty($_POST['userId'])){
                $userId = $_POST['userId'];
            }else{
                $errors[] = 'Please provide the comment userId.';
            }
            if(!empty($_POST['comment'])){
                $commentText = $_POST['comment'];
            }else{
                $errors[] = 'Please provide a comment.';
            }
            if(!empty($_POST['date'])){
                $date = $_POST['date'];
            }else{
                $errors[] = 'Please provide the comment date.';
            }
            if(!empty($_POST['testcaseId'])){
                $testcaseId = $_POST['testcaseId'];
            }else{
                $errors[] = 'Please provide the comment testcaseId.';
            }
            if(count($errors)==0){
                $Comment->setUserId($userId);
                $Comment->setComment($commentText);
                $Comment->setDate($date);
                $Comment->setTestcaseId($testcaseId);
                $newItemId = $Comment->save();
                $output = array(
                    'success' => true,
                    'message' => 'The new comment has been successfully added.',
                    'id' => $newItemId,
                );
            }else{
                $output = array(
                    'success' => false,
                    'message' => $errors
                );
            }
        }
        // ******************************************* Edit comment
        if($subaction === 'edit'){
            $Comment = $Comment->getById($id);
            $errors = array();
            if($Comment === false){
                $error[] = 'There is no comment with provided id.';
            }
            if(!empty($_POST['userId'])){
                $userId = $_POST['userId'];
            }else{
                $errors[] = 'Please provide the comment userId.';
            }
            if(!empty($_POST['comment'])){
                $commentText = $_POST['comment'];
            }else{
                $errors[] = 'Please provide a comment.';
            }
            if(!empty($_POST['date'])){
                $date = $_POST['date'];
            }else{
                $errors[] = 'Please provide the comment date.';
            }
            if(!empty($_POST['testcaseId'])){
                $testcaseId = $_POST['testcaseId'];
            }else{
                $errors[] = 'Please provide the comment testcaseId.';
            }
            if(count($errors)==0){
                $Comment->setUserId($userId);
                $Comment->setComment($commentText);
                $Comment->setDate($date);
                $Comment->setTestcaseId($testcaseId);
                $Comment->save();
                $output = array(
                    'success' => true,
                    'message' => 'The comment has been successfully updated.'
                );
            }else{
                $output = array(
                    'success' => false,
                    'message' => $errors
                );
            }
        }
        
        // ******************************************* Delete comment
        if($subaction === 'delete'){
            $Comment = $Comment->getById($id);
            $errors = array();
            if($Comment === false){
                $error[] = 'There is no comment with provided id.';
            }
            if(count($errors)==0){
                $Comment->delete();
                $output = array(
                    'success' => true,
                    'message' => 'The comment has been successfully deleted.'
                );
            }else{
                $output = array(
                    'success' => false,
                    'message' => $errors
                );
            }
        }
    }

    //Convert the output array to json and print on the screen
    echo(json_encode($output));
?>