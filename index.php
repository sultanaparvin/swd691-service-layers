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

    //Get action,subaction and id from URL
    if(!empty($_GET['action'])){
        $action = $_GET['action'];
    }
    if(!empty($_GET['subaction'])){
        $subaction = $_GET['subaction'];
    }
    if(!empty($_GET['id'])){
        $id = $_GET['id'];
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
        // ******************************************* 
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
    }else if($action === 'projects'){

    }else if($action === 'testcase'){

    }else if($action === 'comments'){

    }

    //Convert the output array to json and print on the screen
    echo(json_encode($output));
?>