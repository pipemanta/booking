<?php

class Place
{

    // database connection and table name
    private $conn;
    private $table_name = "place";

    // object properties
    public $id;
    public $name;
    public $description;
    public $category_id;
    public $rooms;
    public $toilets;
    public $price;
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
                    name=:name, description=:description, category_id=:category_id, rooms=:rooms, toilets=:toilets, price=:price, created=:created",
            $this->table_name);

        /** @var PDOStatement $stmt */
        $stmt = $this->conn->prepare($query);

        // to get time-stamp for 'created' field
        $this->timestamp = date('Y-m-d H:i:s');

        // bind values
//        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":rooms", $this->rooms);
        $stmt->bindParam(":toilets", $this->toilets);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":created", $this->timestamp);

//        var_dump($this);

        try {
            $stmt->execute();
            var_dump($stmt);
        } catch (PDOException $exception){
            var_dump($exception);
            return $exception->getMessage();
        }

        return true;

    }

    function update(){

        //update query
//        $query = sprintf("INSERT INTO %s SET
//                    name=:name, description=:description, category_id=:category_id, rooms=:rooms, toilets=:toilets, price=:price, modified=:modified where id=:id",
//            $this->table_name);

        $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                price = :price,
                description = :description,
                toilets = :toilets,
                rooms = :rooms,
                category_id  = :category_id
            WHERE
                id = :id";

        /** @var PDOStatement $stmt */
        $stmt = $this->conn->prepare($query);

//        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":rooms", $this->rooms);
        $stmt->bindParam(":toilets", $this->toilets);
        $stmt->bindParam(":price", $this->price);
//        $stmt->bindParam(":id", $this->id);

//        var_dump($this);

        // execute the query
//        if($stmt->execute()){
//            return true;
//        }
//
//        return false;

        try {
            $stmt->execute();
//            var_dump($stmt);
        } catch (PDOException $exception){
//            var_dump($exception);
            return $exception->getMessage();
        }

        return true;

    }
    
    // used for paging products
    public function countAll(){

        $query = "SELECT id FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }

    function readAll($from_record_num, $records_per_page){

        $query = "SELECT
        id, name, description, category_id, rooms, toilets, price
        FROM
        " . $this->table_name . "
        ORDER BY
        name ASC
        LIMIT
        {$from_record_num}, {$records_per_page}";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }

    function readOne(){

        $query = "SELECT
                name, description, category_id, rooms, toilets, price
            FROM
                " . $this->table_name . "
            WHERE
                id = ?
            LIMIT
                0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->description = $row['description'];
        $this->category_id = $row['category_id'];
        $this->rooms = $row['rooms'];
        $this->toilets = $row['toilets'];
        $this->price = $row['price'];
    }
}