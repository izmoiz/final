<?php 

//Require database and models
require('config/Database.php');
require('models/Quotes.php');
require('models/Authors.php');
require('models/Categories.php');

//Connect to Database
$database = new Database();
$db = $database->connect();

//Instantiate models
$quotes = new Quotes($db);
$authors = new Authors($db);
$categories = new Categories($db);

//Get Parameters from URL for controller
$authorId = filter_input(INPUT_GET, 'authorId', FILTER_VALIDATE_INT);
$categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);
$limit = filter_input(INPUT_GET,'limit',FILTER_VALIDATE_INT);

// Read Data
$author = $authors->read();
$category = $categories->read();
$quote = $quotes->read();

if($authorId && $categoryId){
    $quotes->categoryId = $categoryId;
    $quotes->authorId = $authorId;
    //Read data
    $results = $quotes->read_by_author_and_cat();
    
    $quote = $results->fetchAll();
    
    $results->closeCursor();

    if (count($quote) == 0)
    {
        include('view/no_quotes.php');
    }else{
    include('view/quote_list.php');
    }
}
//Get quote data
else if($authorId) {
$quotes->authorId = $authorId;
//Read data
$results = $quotes->read_by_author();

$quote = $results->fetchAll();

$results->closeCursor();

include('view/quote_list.php');

} else if($categoryId){
    $quotes->categoryId = $categoryId;
    //Read data
    $results = $quotes->read_by_category();
    
    $quote = $results->fetchAll();
    
    $results->closeCursor();
    include('view/quote_list.php');

} else {
    //Read data
    $results = $quotes->read();
    
    $quote = $results->fetchAll();
    
    $results->closeCursor();
    
    include('view/quote_list.php');
}
?>
