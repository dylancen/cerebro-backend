<?php
  include 'auth.php';
  $uri_token = generate_encoded_auth_token();
  echo "Token: $uri_token\n";
  echo verify_encoded_auth_token($uri_token) ? "Token verified\n" : "Invalid token\n"; //correct token
  echo verify_encoded_auth_token($uri_token."bruh") ? "Token verified\n" : "Invalid token\n"; //incorrect token
?>
