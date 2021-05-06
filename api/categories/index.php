<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//Required db and model
require '../../config/Database.php';
require '../../models/Categories.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate Author object
$categories = new Categories($db);

// Categories query
$result = $categories->read();
// Get row count
$num = $result->rowCount();

// Check if any categories
if ($num > 0) {
    // Category array
    $cat_arr = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $cat_item = [
            'id' => $id,
            'category' => $category,
        ];
        // Push to "data"
        array_push($cat_arr, $cat_item);
    }

    // Convert to JSON & output
    echo json_encode($cat_arr);
} else {
    // No categories
    echo json_encode(['message' => 'No categories Found']);
}
