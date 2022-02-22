<?php
  include '../auth.php';
  include 'user_website.php';
  $_POST = json_decode(file_get_contents('php://input'), true);

  if (!verify_encoded_auth_token($_POST['auth_token'], $_POST)){
    send_error_response('Unauthorized request');
    die();
  }

  if (isset($_POST['credential_id'])){
    $credential_id = $_POST['credential_id'];
  }else{
    send_error_response('Credential id not passed');
    die();
  }

  if (isset($_POST['user_website_credentials'])){
    $credentials = $_POST['user_website_credentials'];
  }else{
    send_error_response('New credentials not passed');
    die();
  }

  $user_website = new User_Website();
  $user_website->prepare_update_query();
  $user_website->bind_update_params($credentials, $credential_id);
  if ($user_website->execute_update()){
    send_ok_response("Website entry updated successfully");
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
