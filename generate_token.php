<?php
  include 'auth.php';
  echo var_dump($_GET);
  echo "\n\"";
  echo generate_encoded_auth_token($_GET);
  echo "\"\n";
?>