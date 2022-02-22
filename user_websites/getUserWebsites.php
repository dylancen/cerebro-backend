<?php
  include '../auth.php';
  include 'user_website.php';
  
  $_POST = json_decode(file_get_contents('php://input'), true);
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
  
  $user_website = new User_Website();

  $user_website->prepare_get_query();
  
  $user_website->bind_get_params($uid);

  if ($user_website->execute_get()){
    $result = $user_website->get_results();
    $rows = array();
    while($r = $result->fetch_assoc()) {
      array_push($rows, json_encode($r));
    }
    send_results(array('user_websites' => json_encode($rows)));
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

  function send_results($results){
    http_response_code(200);
    header('Content-Type: application/json');
    header("Cache-Control: no-cache, must-revalidate");
    $token = generate_encoded_auth_token($results);
    $results['auth_token'] = $token;
    echo json_encode($results);
  }
?>
