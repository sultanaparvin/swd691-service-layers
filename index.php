<?php 
    require_once('config.php');
    //Set default values
    $output = array(
        success => false,
        message : 'Error! Wrong parameters.'
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

    //API If statement
    if($action === 'users'){

    }else if($action === 'projects'){

    }else if($action === 'testcase'){

    }else if($action === 'comments'){

    }
?>