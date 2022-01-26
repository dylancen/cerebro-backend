<?php
  require 'user.php';
  require '../auth.php';

  $_POST = json_decode(file_get_contents('php://input'), true);

  if (!verify_encoded_auth_token($_POST['auth_token'], $_POST)){
    send_error_response('Unauthorized request');
    die();
  }

  if (isset($_POST['username'])){
    $username = $_POST['username'];
  }else{
    send_error_response('Username not set');
    die();
  }

  if (isset($_POST['public_key'])){
    $pkey = $_POST['public_key'];
  }else{
    send_error_response('pwd not set');
    die();
  }

  if (isset($_POST['security_question'])){
    $secq = $_POST['security_question'];
  }else{
    send_error_response('Sec quest not set');
    die();
  }

  if (isset($_POST['security_answer'])){
    $seca = $_POST['security_answer'];
  }else{
    send_error_response('Sec ans not set');
    die();
  }

  $user = new User();
  $user->prepare_insert_query();
  $user->bind_insert_params($username, $pkey, $secq, $seca);
  if ($user->execute_insert()){
    send_ok_response("Row added successfully");
  }else{
    send_error_response($user->error());
  }

  function send_error_response($message){
    http_response_code(400);
    header('Content-Type: application/json');
    header("Cache-Control: no-cache, must-revalidate");
    $responseMap = array('message' => $message);
    $responseMap['auth_token'] = generate_encoded_auth_token($responseMap);
    echo json_encode($responseMap); 
  }

  function send_ok_response($message){
    http_response_code(200);
    header('Content-Type: application/json');
    header("Cache-Control: no-cache, must-revalidate");
    $responseMap = array('message' => $message);
    $responseMap['auth_token'] = generate_encoded_auth_token($responseMap);
    echo json_encode($responseMap); 
  }
?>
