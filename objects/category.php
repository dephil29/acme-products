<?php

class Category{

    private $conn;
    private $table_name = 'categories';

    // object properties
    public $id;
    public $name;
    public $description;
    public $timestamp;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){
        try{
            // insert query
            $query = "INSERT INTO categories
                SET name=:name, description=:description, created=:created"; 
                
                //prepare the query for 
                $stmt = $this->conn->prepare($query);

                // sanitize
                $name = htmlspecialchars(strip_tags($this->name));
                $description = htmlspecialchars(strip_tags($this->description));

                //bind the parameters
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);

                // We need the created variable to know when the record was created
                // also, to comply with strict standards: only variables should be passed
                // by reference
                $created = date('Y-m-d H:i:s');
                $stmt->bindParam(':created', $created);

                // Execute the query
                if($stmt->execute()){
                    return true;
                }else{
                    return false;
                }
        }catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        } 
    }

    public function readAll(){
        // Select all the data
        $query = "SELECT DISTINCT c.id, c.name, c.description
            FROM " . $this->table_name . " c
            LEFT JOIN products p
                ON c.id=p.category_id
            ORDER BY category_id ASC";
        // right above this comment is where you fucked up
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($results);
    }

    public function readOne(){
        // Select all the data
        $query = "SELECT DISTINCT c.id, c.name
        FROM " . $this->table_name . " c
        LEFT JOIN products p
            ON c.id=p.category_id
        WHERE c.id=:id";

        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($results);
    }

    public function update(){
        $query = "UPDATE categories
            SET name=:name, description=:description
            WHERE id=:id";

        // prepare query for execution
        $stmt = $this->conn->prepare($query);
        var_dump($stmt);
        // sanitize
        $name = htmlspecialchars(strip_tags($this->name));
        $description = htmlspecialchars(strip_tags($this->description));
        $id = htmlspecialchars(strip_tags($this->id));
        var_dump($name);
        var_dump($description);
        var_dump($id);
        //bind the parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id);
        var_dump($stmt);
        // execute the query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function delete($ins){
        // Query to delete multiple records
        $query = "DELETE FROM products WHERE id IN (:ins)";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $ins = htmlspecialchars(strip_tags($ins));

        // bind the parameter
        $stmt->bindParam(':ins', $ins);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}