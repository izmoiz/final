<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require '../../config/Database.php';
require '../../models/Quotes.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$quotes = new Quotes($db);

// Get ID from URL
$quotes->id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// Get quote
$quotes->read_single();

// Create array
$quote_array = [
    'id' => $quotes->id,
    'quote' => $quotes->quote,
    'authorId' => $quotes->authorId,
    'author_name' => $quotes->author_name,
    'categoryId' => $quotes->categoryId,
    'category_name' => $quotes->category_name,
];

//Convert to JSON
print_r(json_encode($quote_array));
