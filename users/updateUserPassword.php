<?php
  include '../auth.php';
  include 'user.php';
  $_POST = json_decode(file_get_contents('php://input'), true);

  if (!verify_encoded_auth_token($_POST['auth_token'], $_POST)){
    send_error_response('Unauthorized request');
    die();
  }

  if (isset($_POST['user_id'])){
    $user_id = $_POST['user_id'];
  }else{
    send_error_response('User id not passed');
    die();
  }

  if (isset($_POST['password_hash'])){
    $phash = $_POST['password_hash'];
  }else{
    send_error_response('New new password not passed');
    die();
  }

  if (isset($_POST['encrypted_password'])){
    $penc = $_POST['encrypted_password'];
  }else{
    send_error_response('Password encryption not passed');
    die();
  }

  $user = new User();
  $user->prepare_update_query();
  $user->bind_update_params($phash, $user_id, $penc);
  if ($user->execute_update()){
    send_ok_response("User password updated successfully");
  }else{
    send_error_response($user_website->error());
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
