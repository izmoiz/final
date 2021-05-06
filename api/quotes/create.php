<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
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

$quotes->quote = $data->quote;
$quotes->authorId = $data->authorId;
$quotes->categoryId = $data->categoryId;

// Create Post
if (!empty($quotes->create())) {
    echo json_encode(['message' => 'Quote created']);
} else {
    echo json_encode(['message' => 'Quote not created. Missing required parameters. Please check your parameters and data and try again.']);
}
