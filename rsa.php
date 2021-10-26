<?php
  set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
  require 'Crypt/RSA.php';

  function generate_key_pair(){
    $rsa = new Crypt_RSA();
 
    $rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS1);
    $rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS1);

    //define('CRYPT_RSA_EXPONENT', 65537);
    //define('CRYPT_RSA_SMALLEST_PRIME', 64); // makes it so multi-prime RSA is used
    extract($rsa->createKey()); // == $rsa->createKey(1024) where 1024 is the key size  
    file_put_contents('./public_key.txt', $publickey);
    file_put_contents('./private_key.txt', $privatekey);
  }

  function sign_auth_token($argstr){ //pass argument string
    $rsa = new Crypt_RSA();
    $rsa->loadKey(file_get_contents('./private_key.txt')); // private key
    $rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
    $signature = $rsa->sign($argstr);
    return $signature;
  }

  function verify_auth_token($argstr, $signature){ //pass argument string and signature in binary
    $rsa = new Crypt_RSA();
    $rsa->loadKey(file_get_contents('./public_key.txt')); // public key
    $rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
    $result = $rsa->verify($argstr, $signature) ? true : false;
    return $result; 
  }
?>
