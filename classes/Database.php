<?php

// Database class
class Database
{
    // Database connection properties
    private string $servername = "localhost";
    private string $username = "root";
    private string $password = "";
    private string $dbname = "phpauthstarter";

    // Connect to the database
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