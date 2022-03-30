<?php
  require '../db.php';
  class Supported_Website extends Db{
    function prepare_get_query(){
      return $this->prepare_query('SELECT * FROM SupportedWebsites');
    }

    function execute_get(){
      return $this->execute();
    }

  }
?>
