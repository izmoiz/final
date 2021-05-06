<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');


require('../../config/Database.php');
require('../../models/Categories.php');

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$categories = new Categories($db);

// Get raw posted data
$data = !empty((file_get_contents("php://input"))) ? json_decode(file_get_contents("php://input")) : die();

$categories->id = $data->id;
$categories->category = $data->category;

// Create Post
if ($categories->create()) {
    echo json_encode(
        array('message' => 'Category created')
    );
} else {
    echo json_encode(
        array('message' => 'Category not created')
    );
}