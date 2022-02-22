<?php
  require '../db.php';
  class User_Website extends Db{
    function prepare_insert_query(){
      return $this->prepare_query('INSERT INTO UserWebsiteCredentials(user_id, website_id, user_website_credentials) VALUES (?,?,?)');
    }

    function bind_insert_params($userid, $websiteid, $user_creds){
      return $this->query->bind_param('iis', $userid, $websiteid, $user_creds);
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
      return $this->prepare_query('SELECT * FROM UserWebsiteCredentials AS c INNER JOIN SupportedWebsites AS w ON c.website_id=w.website_id WHERE user_id=?');
    }

    function bind_get_params($userid){
      return $this->query->bind_param('i', $userid);
    }

    function execute_get(){
      return $this->execute();
    }

    function prepare_update_query(){
      return $this->prepare_query('UPDATE UserWebsiteCredentials SET user_website_credentials=? WHERE credential_id=?');
    }

    function bind_update_params($credential_str, $credentialid){
      return $this->query->bind_param('si', $credential_str, $credentialid);
    }

    function execute_update(){
      return $this->execute();
    }

    function prepare_delete_query(){
      return $this->prepare_query('DELETE FROM UserWebsiteCredentials WHERE credential_id=?');
    }

    function bind_delete_params($credentialid){
      return $this->query->bind_param('i', $credentialid);
    }

    function execute_delete(){
      return $this->execute();
    }
  }
?>
