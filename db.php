<?php
  class Db{
    protected $database;
    protected $query;

    //hello world
    function __construct() {
      $this->database = new mysqli('localhost','root','password','project');
      if (!$this->database) {
        die("Database failed to initialize\n");
      }
    } 

    protected function prepare_query($query){
      $this->query = $this->database->prepare($query); 
      if (!$this->query) {
        $error = $this->database->errno . ' ' . $this->database->error . "\n";
        die($error);
      }
      return true;
    }

    function execute(){
      return $this->query->execute();
    }

    function get_results(){
      return $this->query->get_result();
    }

    function error(){
      return $this->query->error;
    }

    function connect_error(){
      return $this->database->connect_error;
    }
  } 
?>
