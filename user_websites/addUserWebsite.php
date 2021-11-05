<?php
  include '../auth.php';
  include 'user_website.php';
  $_POST = json_decode(file_get_contents('php://input'), true);
  //echo "\n";
  //echo var_dump($_POST);
  //echo "\n"; 
  if (!verify_encoded_auth_token($_POST['auth_token'], $_POST)){
    send_error_response('Unauthorized request');
    die();
  }

  if (isset($_POST['user_id'])){
    $uid = $_POST['user_id'];
  }else{
    send_error_response('User id not passed');
    die();
  }

  if (isset($_POST['website_id'])){
    $wid = $_POST['website_id'];
  }else{
    send_error_response('Website id not passed');
    die();
  }

  if (isset($_POST['user_website_credentials'])){
    $user_creds = $_POST['user_website_credentials'];
  }else{
    send_error_response('No credentials passed');
    die();
  }

  $user_website = new User_Website();
  $user_website->prepare_insert_query();
  $user_website->bind_insert_params($uid, $wid, $user_creds);
  if ($user_website->execute_insert()){
    send_ok_response("Row added successfully");
  }else{
    send_error_response($user_website->error());
  }

  function send_error_response($message){
    http_response_code(400);
    header('Content-Type: application/json');
    header("Cache-Control: no-cache, must-revalidate");
    echo json_encode(array('message' => $message));
  }

  function send_ok_response($message){
    http_response_code(200);
    header('Content-Type: application/json');
    header("Cache-Control: no-cache, must-revalidate");
    echo json_encode(array('message' => $message));
  }
?>
