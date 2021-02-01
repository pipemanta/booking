<?php

class Place
{

    // database connection and table name
    private $conn;
    private $table_name = "place";

    // object properties
    public $id;
    public $name;
    public $price;
    public $description;
    public $category_id;
    public $timestamp;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    // create place
    function create()
    {

        //write query
        $query = sprintf("INSERT INTO %s SET
                    name=:name, price=:price, description=:description, category_id=:category_id, created=:created",
            $this->table_name);

        /** @var PDOStatement $stmt */
        $stmt = $this->conn->prepare($query);

        // to get time-stamp for 'created' field
        $this->timestamp = date('Y-m-d H:i:s');

        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":created", $this->timestamp);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = $stmt->errorInfo();
//            var_dump($error);
            return $error[2];
        }

    }
}