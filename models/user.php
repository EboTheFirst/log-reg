<?php
class user{
    public $email; 
    public $username;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function read_user_info(){
        // Create query
        $query = 'SELECT 
        *
        FROM public.users;';
    
          //Prepare statement
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
        return $stmt;
      }
    
      public function read_one_user_info($email){
        // Create query
        $query = 'SELECT 
        * FROM public.users WHERE email = ? LIMIT 1;';
    
          //Prepare statement
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(1, $email);
          $stmt->execute();
        return $stmt;
      }

    public function token_generator(){
      $token = openssl_random_pseudo_bytes(16);
 
      //Convert the binary data into hexadecimal representation.
      $token = bin2hex($token);
      return $token;
   }

	
}