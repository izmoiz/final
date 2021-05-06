<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

require '../../config/Database.php';
require '../../models/Quotes.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$quotes = new Quotes($db);

// Get raw posted data
$data = !empty(file_get_contents("php://input")) ? json_decode(file_get_contents("php://input")) : die();

//Set ID to update
$quotes->quote = $data->quote;
$quotes->authorId = $data->authorId;
$quotes->categoryId = $data->categoryId;
$quotes->id = $data->id;

// Create Post
if ($quotes->update()) {
    echo json_encode(['message' => 'Quote updated']);
} else {
    echo json_encode(['message' => 'Quote not updated']);
}
