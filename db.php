<?php
  class Db{
    protected $database;
    protected $query;

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
    }

    function execute(){
      $this->query->execute();
    }

    function get_query(){
      return $this->query;
    }
  } 
?>
