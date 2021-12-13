<?php
  include '../auth.php';
  //echo var_dump($_GET);
  //$_GET = array("username" => "badstudent@gmail.com", "public_key" => "password", "security_question" => "Have you done Jeffreys homework?", "security_answer" => "Obviously not!");
  $_GET = array("user_id" => 7);
  echo "\n\"";
  echo generate_encoded_auth_token($_GET);
  echo "\"\n";
?>
