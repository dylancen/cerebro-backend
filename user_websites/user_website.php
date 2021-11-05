<?php
  require '../db.php';
  class User_Website extends Db{
    function prepare_insert_query(){
      $this->prepare_query('INSERT INTO UserWebsiteCredentials(user_id, website_id, user_website_credentials) VALUES (?,?,?)');
    }

    function bind_insert_params($userid, $websiteid, $user_creds){
      $this->query->bind_param('iis', $userid, $websiteid, $user_creds);
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
