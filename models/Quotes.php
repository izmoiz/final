<?php

class Quotes
{
    //DB Stuff
    private $conn;
    private $table = 'quotes';

    //Quotes Properties
    public $id;
    public $quote;
    public $authorId;
    public $categoryId;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get quotes
    public function read()
    {
        //Create Query
        $query =
            'SELECT 
            c.category as category_name,
            a.author as author_name,
            q.id,
            q.quote,
            q.authorId,
            q.categoryId 
            FROM 
            ' .
            $this->table .
            ' q
            LEFT JOIN 
            categories c ON q.categoryId = c.id
            LEFT JOIN 
            authors a ON q.authorId = a.id';

        if ($this->authorId && $this->categoryId) {
            $query = $query . ' WHERE q.authorId = :authorId AND q.categoryId = :categoryId';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':authorId', $this->authorId);
            $stmt->bindParam(':categoryId', $this->categoryId);
            //Execute query
            $stmt->execute();
        } elseif ($this->authorId) {
            $query = $query . ' WHERE q.authorId = :authorId ';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':authorId', $this->authorId);
            //Execute query
            $stmt->execute();
        } elseif ($this->categoryId) {
            $query = $query . " WHERE q.categoryId = :categoryId ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':categoryId', $this->categoryId);
            //Execute query
            $stmt->execute();
        } else {
            // //Prepare Statement
            // $stmt = $this->conn->prepare($query);
            $stmt = $this->conn->prepare($query);

            //Execute query
            $stmt->execute();
        }
        return $stmt;
    }

    //Get quotes by author
    public function read_by_author()
    {
        //Create Query
        $query =
            'SELECT 
            c.category as category_name,
            a.author as author_name,
            q.id,
            q.quote,
            q.authorId,
            q.categoryId 
            FROM 
            ' .
            $this->table .
            ' q
            LEFT JOIN 
            categories c ON q.categoryId = c.id
            LEFT JOIN 
            authors a ON q.authorId = a.id
            WHERE 
            q.authorId = :authorId
            ORDER BY 
            id ASC';

        //Prepare Statement
        $stmt = $this->conn->prepare($query);
        //Bind data
        $stmt->bindParam(':authorId', $this->authorId);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    //Get quotes by category
    public function read_by_category()
    {
        //Create Query
        $query =
            'SELECT 
            c.category as category_name,
            a.author as author_name,
            q.id,
            q.quote,
            q.authorId,
            q.categoryId 
            FROM 
            ' .
            $this->table .
            ' q
            LEFT JOIN 
            categories c ON q.categoryId = c.id
            LEFT JOIN 
            authors a ON q.authorId = a.id
            WHERE 
            q.categoryId = :categoryId
            ORDER BY 
            id ASC';

        //Prepare Statement
        $stmt = $this->conn->prepare($query);
        //Bind data
        $stmt->bindParam(':categoryId', $this->categoryId);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    //Get quotes by category
    public function read_by_author_and_cat()
    {
        //Create Query
        $query =
            'SELECT 
            c.category as category_name,
            a.author as author_name,
            q.id,
            q.quote,
            q.authorId,
            q.categoryId 
            FROM 
            ' .
            $this->table .
            ' q
            LEFT JOIN 
            categories c ON q.categoryId = c.id
            LEFT JOIN 
            authors a ON q.authorId = a.id
            WHERE 
            q.authorId = :authorId 
            AND
            q.categoryId = :categoryId
            ORDER BY 
            id ASC';

        //Prepare Statement
        $stmt = $this->conn->prepare($query);
        //Bind data
        $stmt->bindParam(':authorId', $this->authorId);
        $stmt->bindParam(':categoryId', $this->categoryId);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get specific number of quotes
    public function read_limited()
    {
        //Create Query
        $query =
            'SELECT 
        c.category as category_name,
        a.author as author_name,
        q.id,
        q.quote,
        q.authorId,
        q.categoryId 
        FROM 
        ' .
            $this->table .
            ' q
        LEFT JOIN 
            categories c ON q.categoryId = c.id
        LEFT JOIN 
            authors a ON q.authorId = a.id
        LIMIT 0,?';

        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindValue(1, $this->limit, PDO::PARAM_INT);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get 1 Quote
    public function read_single()
    {
        //Create Query
        $query =
            'SELECT 
                c.category as category_name,
                a.author as author_name,
                q.id,
                q.quote,
                q.authorId,
                q.categoryId 
                FROM 
                ' .
            $this->table .
            ' q
                LEFT JOIN 
                    categories c ON q.categoryId = c.id
                LEFT JOIN 
                    authors a ON q.authorId = a.id
                WHERE 
                    q.id = ?
                LIMIT 0,1';

        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindParam(1, $this->id);

        //Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->id = $row['id'];
        $this->quote = $row['quote'];
        $this->authorId = $row['authorId'];
        $this->author_name = $row['author_name'];
        $this->categoryId = $row['categoryId'];
        $this->category_name = $row['category_name'];
    }

    // Create Quote
    public function create()
    {
        //Create Query
        $query =
            'INSERT INTO ' .
            $this->table .
            ' 
            SET 
                quote = :quote,
                authorId = :authorId,
                categoryId = :categoryId';

        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->authorId = htmlspecialchars(strip_tags($this->authorId));
        $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

        //Bind Data
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':authorId', $this->authorId);
        $stmt->bindParam(':categoryId', $this->categoryId);

        // Exectute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        json_encode("Error: %s.\n", $stmt->error);

        return false;
    }

    //Update quote
    public function update()
    {
        //Create Query
        $query =
            'UPDATE ' .
            $this->table .
            ' 
            SET 
                quote = :quote,
                authorId = :authorId,
                categoryId = :categoryId
            WHERE
                id = :id';

        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->authorId = htmlspecialchars(strip_tags($this->authorId));
        $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind Data
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':authorId', $this->authorId);
        $stmt->bindParam(':categoryId', $this->categoryId);
        $stmt->bindParam(':id', $this->id);

        // Exectute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        json_encode("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delete Quote
    public function delete()
    {
        //Query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind Data
        $stmt->bindParam(':id', $this->id);

        // Exectute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        json_encode("Error: %s.\n", $stmt->error);

        return false;
    }
}
