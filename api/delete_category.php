<?php
header("Access-Control-Allow-Origin: *");
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
    var_dump($_POST['del_ins']);
    $ins = '';
    foreach($_POST['del_ins'] as $id){
        $ins .= "{$id},";
    }

    $ins = trim($ins, ',');

    // delete the product
    echo $category->delete($ins) ? 'true' : 'false';
}