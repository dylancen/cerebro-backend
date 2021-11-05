<?php
  include '../auth.php';
  $uri_token = generate_encoded_auth_token($_GET);
  echo "Token: $uri_token\n";
  echo verify_encoded_auth_token($uri_token, $_GET) ? "Token verified\n" : "Invalid token\n"; //correct token
  echo verify_encoded_auth_token($uri_token."b", $_GET) ? "Token verified\n" : "Invalid token\n"; //incorrect token
?>
