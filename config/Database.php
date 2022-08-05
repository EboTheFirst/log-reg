<?php 
  class Database {

    // private $host = 'localhost';
    // private $port = '5433';
    // private $db_name = 'log_reg';
    // private $username = 'postgres';
    // private $password = '2001'; 
    private $host = 'ec2-44-209-186-51.compute-1.amazonaws.com';
    private $port = '5432';
    private $db_name = 'd7p9626muhphd6';
    private $username = 'hucogbiapascdz';
    private $password = '36049fa3d38eae6e3d9b4913b7251996c88a09ed944b40d5378d1a4cb254b0e6'; 
    private $conn;
    private $dsn;
    
    public function connect() {
        $this->conn = null;
        $this->dsn = 'pgsql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->db_name. ';user=' . $this->username . ';password=' . $this->password;
        try { 
          $this->conn = new PDO($this->dsn);
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
          echo 'Connection Error: ' . $e->getMessage();
        }
        return $this->conn;
      }
  }
  