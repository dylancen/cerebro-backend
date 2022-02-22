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

  $user_website = new User_Website();
  $user_website->prepare_delete_query();
  $user_website->bind_delete_params($credential_id);
  if ($user_website->execute_delete()){
    send_ok_response("Deleted entry successfully");
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
