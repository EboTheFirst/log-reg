<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/user.php';
  include_once '../../models/auth.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  $user = new user($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $result = $user->read_one_user_info($data->email);

  $row = $result->fetch(PDO::FETCH_ASSOC);

  if(md5($data->password) == $row['password']){
      $data_item = array(
      'token' => $row['token'],
      'email' => $row['email'],
      'username' => $row['username'],
      );
    http_response_code(200);
    echo json_encode($data_item);
  }else{
    http_response_code(401);
    echo 'Illegal Login Request';
  }
  



  


