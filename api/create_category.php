<?php
// If the form was submitted
if($_POST){
    // include core configuration
    include_once '../config/core.php';

    // include database connection
    include_once '../config/database.php';

    // product object
    include_once '../objects/category.php';
    //class instance
    $database = new Database();
    $db = $database -> getConnection();
    $category = new Category($db);

    // Set product property values
    $category->name = $_POST['name'];
    $category->description = $_POST['description'];

    // Create the product
    echo $category->create() ? 'true' : 'false';
}