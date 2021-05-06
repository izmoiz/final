<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');


require('../../config/Database.php');
require('../../models/Authors.php');

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$authors = new Authors($db);

// Get raw posted data
$data = !empty((file_get_contents("php://input"))) ? json_decode(file_get_contents("php://input")) : die();

$authors->id = $data->id;

// Create Post
if ($authors->delete()) {
    echo json_encode(
        array('message' => 'Author deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Author not deleted')
    );
}