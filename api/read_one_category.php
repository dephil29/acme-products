<?php

// include core configuration
include_once '../config/core.php';

// include database connection
include_once '../config/database.php';

// product object
include_once '../objects/category.php';

// class instance
$database=new Database();
$db=$database->getConnection();
$category=new Category($db);

// read one product
$category->id=$_GET['id'];
$results=$category->readOne();

var_dump($category->id);
// output in json format
echo $results;