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

  $user = new User();
  $user->prepare_get_query();
  $user->bind_get_params($username);
  if($user->execute_get()){
    $result = $user->get_results();
    if($result->num_rows > 0){
      $user_entry = $result->fetch_assoc();
      $question = $user_entry["security_question"]; 
      send_ok_response($question);
    }else{
      send_error_response("Invalid username");
    }
  }else{
    send_error_response("Unable execute get statement");
  }
  


  function send_error_response($message){
    http_response_code(400);
    header('Content-Type: application/json');
    header("Cache-Control: no-cache, must-revalidate");
    $responseMap = array('message' => $message);
    $responseMap['auth_token'] = generate_encoded_auth_token($responseMap);
    echo json_encode($responseMap); 
  }

  function send_ok_response($question){
    http_response_code(200);
    header('Content-Type: application/json');
    header("Cache-Control: no-cache, must-revalidate");
    $responseMap = array('security_question' => $question);
    $responseMap['auth_token'] = generate_encoded_auth_token($responseMap);
    echo json_encode($responseMap); 
  }
?>
