<?php 
  class auth {
    // DB stuff
    private $conn;
    private $table_api = 'user_api_auth';

    // Post Properties
    public $username;
    public $password;
    public $token;
    public $client_name;

    public $app_version;
    public $id; 
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }
 
    // Authenticate Api Key
  public function read_api_auth(){
    $query = 'SELECT
              name,
              token_expire,
              app_version
              FROM
          ' . $this->table_api . '
      WHERE token = ?
      LIMIT 1';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->token);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->token_expire = $row['token_expire'];
      $this->client_name = $row['name'];
      $this->app_version = $row['app_version'];
  }

    
  }