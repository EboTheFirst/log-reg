<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  // Main issue was not adding options to the allowed methods since it was 
// always used by CORS preflight requests (this request is automatically 
// issued by a browser ). 

// It checks for example, whether the request methods and headers are accepted 
// by the server. Therefore you need to have a different flow for options
// requests in your php server scripts

// For more info check: https://developer.mozilla.org/en-US/docs/Glossary/Preflight_request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  exit(0);
}

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
  



  


