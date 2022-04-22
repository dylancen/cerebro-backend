<?php
  require '../db.php';
  class User extends Db{
    function prepare_insert_query(){
      $this->prepare_query('INSERT INTO Users(username, password_hash, security_question, security_answer, encrypted_password) VALUES (?,?,?,?,?)');
    }

    function bind_insert_params($username, $pkpass, $secquest, $secans, $enc){
      $this->query->bind_param('sssss', $username, $pkpass, $secquest, $secans, $enc);
    }

    function execute_insert(){
      $this->execute();
      if ($this->database->affected_rows > 0) {
        return true;
      }else{
        return false;
      }
    }
    
    function prepare_get_query(){
      return $this->prepare_query('SELECT * FROM Users WHERE username=?');
    }

    function bind_get_params($username){
      return $this->query->bind_param('s', $username);
    }

    function execute_get(){
      return $this->execute();
    }

    function prepare_update_query(){
      return $this->prepare_query('UPDATE Users SET password_hash=?, encrypted_password=? WHERE user_id=?');
    }

    function bind_update_params($phash, $user_id, $penc){
      return $this->query->bind_param('ssi', $phash, $penc, $user_id);
    }

    function execute_update(){
      return $this->execute();
    }
  }
?>
