<?php
  require 'rsa.php';
  function generate_encoded_auth_token($args){ //returns the uri encoded token string
    ksort($args);
    $string = '';
    foreach($args as $key => $value){ //building argument concatenation
      if ($key != 'auth_token') {
        $string = $string.$value;
      }
    }
    //echo "PHP token: $string\n";
    $signature = sign_auth_token($string);//binary signature
    $url_sig_string = urlencode(base64_encode($signature));//converting to url
    return $url_sig_string;
  } 
  function verify_encoded_auth_token($auth_token, $args){ //returns boolean pass/fail
    $bin_token = base64_decode(urldecode($auth_token));//get binary token
    ksort($args);
    $string = '';
    foreach($args as $key => $value){ //building argument concatenation
      if ($key != 'auth_token') {
        //echo "\n\"$value\"\n";
        $string = $string.$value;
      }
    }
    //echo "\n\"$string\"\n";
    return verify_auth_token($string, $bin_token);
  }
?>
