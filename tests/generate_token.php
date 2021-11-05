<?php
  include '../auth.php';
  //echo var_dump($_GET);
  $_GET = array("user_id" => 8, "website_id" => 1, "user_website_credentials" => "{ \"data\":\"encrypted_data\" }");
  echo "\n\"";
  echo generate_encoded_auth_token($_GET);
  echo "\"\n";
?>
