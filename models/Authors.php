<?php

class Authors
{
    //DB Stuff
    private $conn;
    private $table = 'authors';

    //Quotes Properties
    public $id;
    public $author;

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
            'SELECT *
            FROM 
            ' .
            $this->table .
            '
            ORDER BY 
                id ASC';

        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get 1 Author
    public function read_single()
    {
        //Create Query
        $query =
            'SELECT *
        FROM 
        ' .
            $this->table .
            '
        WHERE
            id = :id
        LIMIT 0,1';

        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindParam(':id', $this->id);

        //Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->id = $row['id'];
        $this->author = $row['author'];
    }

    // Create Author
    public function create()
    {
        //Create Query
        $query =
            'INSERT INTO ' .
            $this->table .
            ' 
            SET 
                id = :id,
                author = :author';

        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->author = htmlspecialchars(strip_tags($this->author));

        //Bind Data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':author', $this->author);

        // Exectute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        json_encode("Error: %s.\n", $stmt->error);

        return false;
    }

    //Update author
    public function update()
    {
        //Create Query
        $query =
            'UPDATE ' .
            $this->table .
            ' 
            SET 
                author = :author
            WHERE
                id = :id';

        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->author = htmlspecialchars(strip_tags($this->author));

        //Bind Data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':author', $this->author);

        // Exectute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        json_encode("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delete author
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
