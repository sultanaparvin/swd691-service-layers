<?php
class Testcase{
    private $id;
    private $name;
    private $action;
    private $expectedResult;
    private $actualResult;
    private $status;
    private $currentUserId;
    private $projectId;

    public function __construct($id = null, $name = null, $action = null, $expectedResult = null, $actualResult = null, $status = null, $currentUserId = null, $projectId = null){
        $this->id = $id;
        $this->name = $name;
        $this->action = $action;
        $this->expectedResult = $expectedResult;
        $this->actualResult = $actualResult;
        $this->status = $status;
        $this->currentUserId = $currentUserId;
        $this->projectId = $projectId;
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
    public function getAction(){
        return $this->action;
    }
    public function setAction($action){
        $this->action = $action;
    }

    public function getExpectedResult(){
        return $this->expectedResult;
    }
    public function setExpectedResult($expectedResult){
        $this->expectedResult = $expectedResult;
    }
    public function getActualResult(){
        return $this->actualResult;
    }
    public function setActualResult($actualResult){
        $this->actualResult = $actualResult;
    }
    public function getStatus(){
        return $this->status;
    }
    public function setStatus($status){
        $this->status = $status;
    }
    public function getCurrentUserId(){
        return $this->currentUserId;
    }
    public function setCurrentUserId($currentUserId){
        $this->currentUserId = $currentUserId;
    }
    public function getProjectId(){
        return $this->projectId;
    }
    public function setProjectId($projectId){
        $this->projectId = $projectId;
    }

    //Get all the testcases
    public function getAll(){
        $output = array();
        global $conn;
        $sql = "SELECT * FROM `testcases`";
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res) > 0){ //Check to make sure table is not empty
            while($row = mysqli_fetch_object($res)){
                $output[] = new Testcase($row->id, $row->name, $row->action, $row->expectedResult, $row->actualResult, $row->status, $row->currentUserId, $row->projectId);
            }
        }
        return $output;
    }

    //Get a testcase by id
    public function getById($id){
        $output = false;
        global $conn;
        $sql = "SELECT * FROM `testcases` WHERE `id`=".$id;
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res) > 0){ //Check to make item exist with this id
            $row = mysqli_fetch_object($res);
            $output = new Testcase($row->id, $row->name, $row->action, $row->expectedResult, $row->actualResult, $row->status, $row->currentUserId, $row->projectId);
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
                    'action' => $item->action,
                    'expectedResult' => $item->expectedResult,
                    'actualResult' => $item->actualResult,
                    'status' => $item->status,
                    'currentUserId' => $item->currentUserId,
                    'projectId' => $item->projectId
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
                'action' => $item->action,
                'expectedResult' => $item->expectedResult,
                'actualResult' => $item->actualResult,
                'status' => $item->status,
                'currentUserId' => $item->currentUserId,
                'projectId' => $item->projectId
            );
        }
        return $output;
    }
//	id	name	action	expectedResult	actualResult	status	currentUserId	projectId
    //Save function handle both insert and update.
    public function save(){
        global $conn;
        if($this->id === null){ //Insert
            $sql = "INSERT INTO `testcases` (`name`,`action`,`expectedResult`,`actualResult`,`status`,`currentUserId`,`projectId`)VALUES('".$this->name."','".$this->action."','".$this->expectedResult."','".$this->actualResult."','".$this->status."',".$this->currentUserId.",".$this->projectId.")";
            mysqli_query($conn,$sql);
            $this->id = mysqli_insert_id($conn);//Retrieve the auto inc id.
            return $this->id;
        }else{ //Update
            $sql = "UPDATE `testcases` SET `name`='".$this->name."' ,`action`='".$this->action."' ,`expectedResult`='".$this->expectedResult."',`actualResult`='".$this->actualResult."',`status`='".$this->status."',`currentUserId`=".$this->currentUserId.",`projectId`=".$this->projectId." WHERE `id`=".$this->id;
            mysqli_query($conn,$sql);
        }
    }

    //Delete function removes a project
    public function delete(){
        global $conn;
        $sql = "DELETE FROM `testcases` WHERE `id`=".$this->id;
        mysqli_query($conn,$sql);
    }
}