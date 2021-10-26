<?php
  require 'rsa.php';
  function generate_encoded_auth_token(){ //returns the uri encoded token string
    ksort($_GET);
    $args = '';
    foreach($_GET as $key => $value){ //building argument concatenation
      if ($key != 'auth_token') {
        $args = $args.$value;
      }
    }
    $signature = sign_auth_token($args);//binary signature
    $url_sig_string = urlencode(base64_encode($signature));//converting to url
    return $url_sig_string;
  } 
  function verify_encoded_auth_token($auth_token){ //returns boolean pass/fail
    $bin_token = base64_decode(urldecode($auth_token));//get binary token
    ksort($_GET);
    $args = '';
    foreach($_GET as $key => $value){ //building argument concatenation
      if ($key != 'auth_token') {
        $args = $args.$value;
      }
    }
    return verify_auth_token($args, $bin_token);
  }
?>
