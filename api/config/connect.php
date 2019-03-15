<?php
class Database{
  private $host = "data.mildvariety.club";
  private $db_name = "test284829";
  private $username = "keith289";
  private $password = "Keithisthecoolest1";
  public $conn;
 
    public function getConnection(){
        $this->conn = null;
        try{
          $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>