<?php

// The Database class handles the database connection
class Database
{
    // Database connection properties
    private string $servername = "localhost";
    private string $username = "root";
    private string $password = "";
    private string $dbname = "phpauthstarter";

    /**
     * Establishes a connection to the database
     *
     * @return PDO|null Returns a PDO object if the connection is successful, null otherwise
     */
    public function connect(): ?PDO
    {
        try {
            // Establish connection
            $bdd = new PDO("mysql:host=$this->servername;dbname=$this->dbname;charset=utf8", $this->username, $this->password);
            // Set error mode
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $bdd;
        } catch (PDOException $e) {
            // Log error
            error_log("DB connection failed: " . $e->getMessage());
            return null;
        }
    }
}