<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require('../../config/Database.php');
require('../../models/Categories.php');

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$categories = new Categories($db);

// Get ID from URL
$categories->id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// Get quote
$categories->read_single();

// Create array
$cat_array = array(
    'id' => $categories->id,
    'category' => $categories->category
);

//Convert to JSON 
print_r(json_encode($cat_array));