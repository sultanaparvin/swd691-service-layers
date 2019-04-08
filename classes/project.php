<?php
class Project{
    private $id;
    private $name;
    private $description;

    public function __construct($id = null, $name = null, $description = null){
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
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
    public function getDescription(){
        return $this->description;
    }
    public function setDescription($description){
        $this->description = $description;
    }

    //Get all the projects
    public function getAll(){
        $output = array();
        global $conn;
        $sql = "SELECT * FROM `projects`";
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res) > 0){ //Check to make sure table is not empty
            while($row = mysqli_fetch_object($res)){
                $output[] = new Project($row->id, $row->name, $row->description);
            }
        }
        return $output;
    }

    //Get a project by id
    public function getById($id){
        $output = false;
        global $conn;
        $sql = "SELECT * FROM `projects` WHERE `id`=".$id;
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res) > 0){ //Check to make item exist with this id
            $row = mysqli_fetch_object($res);
            $output = new Project($row->id, $row->name, $row->description);
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
                    'description' => $item->description
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
                'description' => $item->description
            );
        }
        return $output;
    }

    //Save function handle both insert and update.
    public function save(){
        global $conn;
        if($this->id === null){ //Insert
            $sql = "INSERT INTO `projects` (`name`,`description`)VALUES('".$this->name."','".$this->description."')";
            mysqli_query($conn,$sql);
            $this->id = mysqli_insert_id($conn);//Retrieve the auto inc id.
            return $this->id;
        }else{ //Update
            $sql = "UPDATE `projects` SET `name`='".$this->name."', `description`='".$this->description."' WHERE `id`=".$this->id;
            mysqli_query($conn,$sql);
        }
    }

    //Delete function removes a project
    public function delete(){
        global $conn;
        $sql = "DELETE FROM `projects` WHERE `id`=".$this->id;
        mysqli_query($conn,$sql);
    }
}