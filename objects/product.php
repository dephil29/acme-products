<?php

class Product{

    private $conn;
    private $table_name = 'products';

    // object properties
    public $id;
    public $name;
    public $price;
    public $description;
    public $category_id;
    public $timestamp;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){
        try{
            // insert query
            $query = "INSERT INTO products
                SET name=:name, description=:description, price=:price,
                category_id=:category_id, created=:created"; 
                
                //prepare the query for 
                $stmt = $this->conn->prepare($query);

                // sanitize
                $name = htmlspecialchars(strip_tags($this->name));
                $description = htmlspecialchars(strip_tags($this->description));
                $price = htmlspecialchars(strip_tags($this->price));
                $category_id = htmlspecialchars(strip_tags($this->category_id));

                //bind the parameters
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':category_id', $category_id);

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
        $query = "SELECT p.id, p.name, p.description, p.price, c.name as category_name
            FROM " . $this->table_name . " p
            LEFT JOIN categories c
                ON p.category_id=c.id
            ORDER BY id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($results);
    }

    public function readOne(){
        // Select all the data
        $query = "SELECT p.id, p.name, p.description, 
        p.price, p.category_id, c.name as category_name
        FROM " . $this->table_name . " p 
        LEFT JOIN categories c ON p.category_id=c.id 
        WHERE p.id=:id";

        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return json_encode($results);
    }

    public function update(){
        $query = "UPDATE products
            SET name=:name, description=:description, price=:price, category_id=:category_id
            WHERE id=:id";

        // prepare query for execution
        $stmt = $this->conn->prepare($query);
        var_dump($stmt);
        // sanitize
        $name = htmlspecialchars(strip_tags($this->name));
        $description = htmlspecialchars(strip_tags($this->description));
        $price = htmlspecialchars(strip_tags($this->price));
        $category_id = htmlspecialchars(strip_tags($this->category_id));
        $id = htmlspecialchars(strip_tags($this->id));
        var_dump($name);
        var_dump($description);
        var_dump($price);
        var_dump($category_id);
        var_dump($id);
        //bind the parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
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