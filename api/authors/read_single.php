<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require('../../config/Database.php');
require('../../models/Authors.php');

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$authors = new Authors($db);

// Get ID from URL
$authors->id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// Get quote
$authors->read_single();

// Create array
$author_arr = array(
    'id' => $authors->id,
    'author' => $authors->author
);

//Convert to JSON 
print_r(json_encode($author_arr));