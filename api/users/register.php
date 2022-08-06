<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST, OPTIONS');

  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

  include_once '../../config/Database.php';
  include_once '../../models/user.php';
  include_once '../../models/auth.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $user = new user($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Create query
  $query = 'INSERT INTO public.users(
  email, username, password, token)
  VALUES (?, ?, ?, ?);';
  
  //Prepare statement
  $stmt = $db->prepare($query);

  // Bind ID
  $hashed_password = md5($data->password);
  $stmt->bindParam(1, $data->email);
  $stmt->bindParam(2, $data->username);
  $stmt->bindParam(3, $hashed_password);
  
  $token = $user->token_generator();
  $stmt->bindParam(4, $token);

  try {
    $stmt->execute();
    $data_item = array(
      'token' => $token,
      'email' => $data->email,
      'username' => $data->username,
    );
    http_response_code(201);
    echo json_encode($data_item);
} catch (PDOException $e) {
    echo "Did not work";
 }



  


