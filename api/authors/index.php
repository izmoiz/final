<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//required db and model
require '../../config/Database.php';
require '../../models/Authors.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate Author object
$authors = new Authors($db);

// Authors query
$result = $authors->read();
// Get row count
$num = $result->rowCount();

// Check if any authors
if ($num > 0) {
    // Author array
    $authors_arr = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $author_item = [
            'id' => $id,
            'author' => $author,
        ];
        // Push to "data"
        array_push($authors_arr, $author_item);
    }

    // Convert to JSON & output
    echo json_encode($authors_arr);
} else {
    // No authors
    echo json_encode(['message' => 'No authors Found']);
}
