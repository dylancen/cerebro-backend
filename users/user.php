<?php
  require '../db.php';
  class User extends Db{
    function prepare_insert_query(){
      $this->prepare_query('INSERT INTO Users(username, public_key_pass, security_question, security_answer) VALUES (?,?,?,?)');
    }

    function bind_insert_params($username, $pkpass, $secquest, $secans){
      $this->query->bind_param('ssss', $username, $pkpass, $secquest, $secans);
    }

    function execute_insert(){
      $this->execute();
      if ($this->database->affected_rows > 0) {
        return true;
      }else{
        return false;
      }
    }
  }
?>
