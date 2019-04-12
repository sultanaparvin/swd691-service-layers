<?php
class Comment{
    private $id;
    private $userId;
    private $comment;
    private $date;
    private $testcaseId;

    public function __construct($id = null, $userId = null, $comment = null, $date = null, $testcaseId = null){
        $this->id = $id;
        $this->userId = $userId;
        $this->comment = $comment;
        $this->date = $date;
        $this->testcaseId = $testcaseId;
    }

    //Getters & Setters
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getUserId(){
        return $this->userId;
    }
    public function setUserId($userId){
        $this->userId = $userId;
    }
    public function getComment(){
        return $this->comment;
    }
    public function setComment($comment){
        $this->comment = $comment;
    }
    public function getDate(){
        return $this->date;
    }
    public function setDate($date){
        $this->date = $date;
    }
    public function getTestcaseId(){
        return $this->testcaseId;
    }
    public function setTestcaseId($testcaseId){
        $this->testcaseId = $testcaseId;
    }

    //Get all the comments
    public function getAll(){
        $output = array();
        global $conn;
        $sql = "SELECT * FROM `comments`";
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res) > 0){ //Check to make sure table is not empty
            while($row = mysqli_fetch_object($res)){
                $output[] = new Comment($row->id, $row->userId, $row->comment, $row->date, $row->testcaseId);
            }
        }
        return $output;
    }

    //Get a comment by id
    public function getById($id){
        $output = false;
        global $conn;
        $sql = "SELECT * FROM `comments` WHERE `id`=".$id;
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res) > 0){ //Check to make item exist with this id
            $row = mysqli_fetch_object($res);
            $output = new Comment($row->id, $row->userId, $row->comment, $row->date, $row->testcaseId);
        }
        return $output;
    }

    
    //Get a comments by testcase id
    public function getAllByTestCaseId($testcaseId){
        $output = array();
        global $conn;
        $sql = "SELECT * FROM `comments` WHERE `testcaseId`=".$testcaseId;
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res) > 0){ //Check to make sure table is not empty
            while($row = mysqli_fetch_object($res)){
                $output[] = new Comment($row->id, $row->userId, $row->comment, $row->date, $row->testcaseId);
            }
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
                    'userId' => $item->userId,
                    'comment' => $item->comment,
                    'date' => $item->date,
                    'testcaseId' => $item->testcaseId
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
                'userId' => $item->userId,
                'comment' => $item->comment,
                'date' => $item->date,
                'testcaseId' => $item->testcaseId
            );
        }
        return $output;
    }

    //Get all values by testcase id as array . This helps to access to private properties
    public function getAllByTestCaseIdAsArray($testcaseId){
        $output = array();
        $items = $this->getAllByTestCaseId($testcaseId);
        if(count($items) > 0){ //Check to make sure table is not empty
            foreach($items as $item){
                $output[] = array(
                    'id' => $item->id,
                    'userId' => $item->userId,
                    'comment' => $item->comment,
                    'date' => $item->date,
                    'testcaseId' => $item->testcaseId
                );
            }
        }
        return $output;
    }

    //Save function handle both insert and update.
    public function save(){
        global $conn;
        if($this->id === null){ //Insert
            $sql = "INSERT INTO `comments` (`userId`,`comment`,`date`,`testcaseId`)VALUES(".$this->userId.",'".$this->comment."','".$this->date."',".$this->testcaseId.")";
            mysqli_query($conn,$sql);
            $this->id = mysqli_insert_id($conn);//Retrieve the auto inc id.
            return $this->id;
        }else{ //Update
            $sql = "UPDATE `comments` SET `userId`=".$this->userId.", `comment`='".$this->comment."', `date`='".$this->date."', `testcaseId`=".$this->testcaseId." WHERE `id`=".$this->id;
            mysqli_query($conn,$sql);
        }
    }

    //Delete function removes a comment
    public function delete(){
        global $conn;
        $sql = "DELETE FROM `comments` WHERE `id`=".$this->id;
        mysqli_query($conn,$sql);
    }
}