<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//require DB and models
require '../../config/Database.php';
require '../../models/Quotes.php';
require '../../models/Authors.php';
require '../../models/Categories.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$quotes = new Quotes($db);

// Instantiate category object
$categories = new Categories($db);

// Instantiate Author object
$authors = new Authors($db);

// GET parameters in URL
$authorId = filter_input(INPUT_GET, 'authorId', FILTER_VALIDATE_INT);
$categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);
$limit = filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT);
$random = filter_input(INPUT_GET, 'random', FILTER_VALIDATE_BOOLEAN);

//Get random quotes by author and category
if ($random == 'true' && $authorId && $categoryId) {
    $quotes->authorId = $authorId;
    $quotes->categoryId = $categoryId;

    // Quotes query
    $result = $quotes->read_by_author_and_cat();
    // Get row count
    $num = $result->rowCount();

    // Check if any quotes
    if ($num > 0) {
        // Quote array
        $quotes_arr = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = [
                'id' => $id,
                'quote' => html_entity_decode($quote),
                'author' => $author_name,
                'category' => $category_name,
            ];
            // Push to "data"
            array_push($quotes_arr, $quote_item);
        }

        $items = count($quotes_arr);

        // Convert to JSON & output
        echo json_encode($quotes_arr[rand(0, $items - 1)]);
    } else {
        // No posts
        echo json_encode([
            'message' => 'No Quotes Found',
        ]);
    }
}
// Get random quote from author
elseif ($random == 'true' && $authorId) {
    $quotes->authorId = $authorId;
    // Quotes query
    $result = $quotes->read_by_author();
    // Get row count
    $num = $result->rowCount();

    // Check if any quotes
    if ($num > 0) {
        // Quote array
        $quotes_arr = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = [
                'id' => $id,
                'quote' => html_entity_decode($quote),
                'author' => $author_name,
                'category' => $category_name,
            ];
            // Push to "data"
            array_push($quotes_arr, $quote_item);
        }

        $items = count($quotes_arr);

        // Convert to JSON & output
        echo json_encode($quotes_arr[rand(0, $items - 1)]);
    } else {
        // No posts
        echo json_encode([
            'message' => 'No Quotes Found',
        ]);
    }
}
// Get random quote in a category
elseif ($random == 'true' && $categoryId) {
    $quotes->categoryId = $categoryId;
    // Quotes query
    $result = $quotes->read_by_category();
    // Get row count
    $num = $result->rowCount();

    // Check if any quotes
    if ($num > 0) {
        // Quote array
        $quotes_arr = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = [
                'id' => $id,
                'quote' => html_entity_decode($quote),
                'author' => $author_name,
                'category' => $category_name,
            ];
            // Push to "data"
            array_push($quotes_arr, $quote_item);
        }

        $items = count($quotes_arr);

        // Convert to JSON & output
        echo json_encode($quotes_arr[rand(0, $items - 1)]);
    } else {
        // No posts
        echo json_encode([
            'message' => 'No Quotes Found',
        ]);
    }
}
// Get random quote
elseif ($random == 'true') {
    // Quotes query
    $result = $quotes->read();
    // Get row count
    $num = $result->rowCount();

    // Check if any quotes
    if ($num > 0) {
        // Quote array
        $quotes_arr = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = [
                'id' => $id,
                'quote' => html_entity_decode($quote),
                'author' => $author_name,
                'category' => $category_name,
            ];
            // Push to "data"
            array_push($quotes_arr, $quote_item);
        }

        $items = count($quotes_arr);

        // Convert to JSON & output
        echo json_encode($quotes_arr[rand(0, $items - 1)]);
    } else {
        // No posts
        echo json_encode([
            'message' => 'No Quotes Found',
        ]);
    }
} 
// Get a limited number of quotes
elseif ($limit) {
    $quotes->limit = $limit;
    // Quotes query
    $result = $quotes->read_limited();
    // Get row count
    $num = $result->rowCount();

    // Check if any quotes
    if ($num > 0) {
        // Quote array
        $quotes_arr = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = [
                'id' => $id,
                'quote' => html_entity_decode($quote),
                'author' => $author_name,
                'category' => $category_name,
            ];
            // Push to "data"
            array_push($quotes_arr, $quote_item);
        }

        // Convert to JSON & output
        echo json_encode($quotes_arr);
    } else {
        // No posts
        echo json_encode([
            'message' => 'No Quotes Found',
        ]);
    }
} 
// Get all quotes (also with specified parameters if any)
else {
    $quotes->authorId = $authorId;
    $quotes->categoryId = $categoryId;

    // Quotes query
    $result = $quotes->read();
    // Get row count
    $num = $result->rowCount();

    // Check if any quotes
    if ($num > 0) {
        // Quote array
        $quotes_arr = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = [
                'id' => $id,
                'quote' => html_entity_decode($quote),
                'author' => $author_name,
                'category' => $category_name,
            ];
            // Push to "data"
            array_push($quotes_arr, $quote_item);
        }

        // Convert to JSON & output
        echo json_encode($quotes_arr);
    } else {
        // No posts
        echo json_encode([
            'message' => 'No Quotes Found',
        ]);
    }
}
