<?php
  include '../auth.php';
  //echo var_dump($_GET);
  $_GET = array("user_id" => "7");
  echo "\n\"";
  echo generate_encoded_auth_token($_GET);
  echo "\"\n";
?>
