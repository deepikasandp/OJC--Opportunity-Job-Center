<?php
/**
 * Generic class for handling DB operations.
 */
class DatabaseConfig{
    private $db_username = "";
    private $db_password = "";
    private $db_host = "";
    private $db_name = "";
    private $db_charset = "utf8mb4";
    public $dsn;
    /**
    * use this method to create a connection object.
    */
    function getConnection()
    {        
        $this->dsn = NULL;
        $conn = "mysql:host=" .$this->db_host. ";dbname=" .$this->db_name. ";charset=" .$this->db_charset; 
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            ];
        
         try{
            $this->dsn = new PDO($conn,$this->db_username,$this->db_password,$options);
         } 
         catch(\PDOException $e)
         {
           // throw new \PDOException($e->getMessage(), (int)$e->getCode());
           echo "not connected to database";
         }
         return $this->dsn;
    }
}
?>