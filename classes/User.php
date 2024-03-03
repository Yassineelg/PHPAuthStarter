<?php

// User class
class User
{
    // Database instance
    private Database $db;

    // Constructor
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    // Create a new user
    public function createUser($name, $email, $password, $confirm_password): bool
    {
        // Check password confirmation
        if ($password !== $confirm_password) {
            return false;
        }

        // Connect to the database
        $bdd = $this->db->connect();
        if ($bdd === null) {
            return false;
        }

        // Check if email already exists
        $request = $bdd->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $request->execute(['email' => $email]);
        if ($request->fetch()) {
            return false;
        }

        // Insert new user
        $request = $bdd->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $passwordHash = password_hash($password, PASSWORD_ARGON2ID);
        $request->execute(['name' => $name, 'email' => $email, 'password' => $passwordHash]);

        return true;
    }
}