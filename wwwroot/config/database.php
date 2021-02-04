<?php
class Database{

    // specify your own database credentials
//    private $host = "db";
//    private $db_name = "booking_db";
//    private $username = "booking-user";
//    private $password = "M!Aq12xjcDtLT#Zw";
    public $conn;

    // get the database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO(
                //OLD CONNECTION "mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                sprintf(
                    "mysql:host=%s;port=%d;dbname=%s",
                    getenv("HOSTNAME"),
                    3306,
                    getenv("MYSQL_DATABASE")
                ),
                getenv("MYSQL_USER"),
                getenv("MYSQL_PASSWORD"),
                [PDO::ATTR_PERSISTENT => false]  // array() = [] on php 7+
            );
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}