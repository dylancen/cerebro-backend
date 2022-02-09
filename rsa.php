<?php
  set_include_path('/var/www/html/phpseclib');
  require 'Crypt/RSA.php';

  function generate_key_pair(){
    $rsa = new Crypt_RSA();
 
    $rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS8);
    $rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS8);

    //define('CRYPT_RSA_EXPONENT', 65537);
    //define('CRYPT_RSA_SMALLEST_PRIME', 64); // makes it so multi-prime RSA is used
    extract($rsa->createKey()); // == $rsa->createKey(1024) where 1024 is the key size  
    file_put_contents('/var/www/html/public_key.txt', $publickey);
    file_put_contents('/var/www/html/private_key.txt', $privatekey);
  }

  function sign_auth_token($argstr){ //pass argument string
    $rsa = new Crypt_RSA();
    $rsa->loadKey(file_get_contents('/var/www/html/private_key.txt')); // private key
    $rsa->setSignatureMode(CRYPT_RSA_ENCRYPTION_PKCS1);
    $rsa->setHash('sha256');
    $signature = $rsa->sign($argstr);
    return $signature;
  }

  function verify_auth_token($argstr, $signature){ //pass argument string and signature in binary
    $rsa = new Crypt_RSA();
    $rsa->loadKey(file_get_contents('/var/www/html/public_key.txt')); // public key
    $rsa->setSignatureMode(CRYPT_RSA_ENCRYPTION_PKCS1);
    $rsa->setHash('sha256');
    $result = $rsa->verify($argstr, $signature) ? true : false;
    return $result; 
  }
?>
