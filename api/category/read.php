<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

//Instantiate DB and connect
$database = new Database();
$db = $database->connect();

//Instantiate blog categories object
$categories = new Category($db);

//Blog categories query
$result = $categories->read();

//Get row count
$num = $result->rowCount();

//Check if any categoriess
if($num > 0) {
    //Post array
    $categories_arr = array();
    $categories_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $category_item = array(
            'id' => $id,
            'name' => html_entity_decode($name),  
        );

        //Push to "data"
        array_push($categories_arr['data'], $category_item);
    }

    //Turn to JSON and output
    echo json_encode($categories_arr);

} else {
    //No Posts
    echo json_encode(
        array('message' => 'No Posts Found!')
    );
}