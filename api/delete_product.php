<?php
header("Access-Control-Allow-Origin: *");
// If the form was submitted
if($_POST){
    // include core configuration
    include_once '../config/core.php';

    // include database connection
    include_once '../config/database.php';

    // product object
    include_once '../objects/product.php';
    //class instance
    $database = new Database();
    $db = $database -> getConnection();
    $product = new Product($db);
    var_dump($_POST['del_ids']);
    $ins = '';
    foreach($_POST['del_ids'] as $id){
        $ins .= "{$id},";
    }

    $ins = trim($ins, ',');

    // delete the product
    echo $product->delete($ins) ? 'true' : 'false';
}