<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/user_info.php';
  include_once '../../models/auth.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new user_info($db);
  $auth = new auth($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $auth->token = $data->api_token;
  $auth->read_api_auth();
 
  if (!empty($auth->client_name)) {
    
  $result = $post->read_user_info();
  $num = $result->rowCount();
  // Check if any parcels
  if($num > 0) {
        // Cat array
        $data_arr = array();
        //$cat_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
          $data_item = array(
            'email' => $email,
            'username' => $username,
            'password' => $password,
          );
          // Push to "data"
          //array_push($cat_arr['data'], $cat_item);
          array_push($data_arr, $data_item);
        }

        // Turn to JSON & output
        echo json_encode($data_arr);

  } else {
        // No Categories
        echo json_encode(
          array('message' => 'No error loading data Found')
        );
  }

  }
 
