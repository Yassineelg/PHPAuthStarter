<?php

class User
{
    private Database $db;

    // Define the password hashing algorithm as a constant
    private const string PASSWORD_ALGO = PASSWORD_ARGON2ID;

    // Constructor takes a Database object as a dependency
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * Create a new user
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $confirm_password
     * @return bool Returns true if the user was created successfully, false otherwise
     */
    public function createUser(string $name, string $email, string $password, string $confirm_password): bool
    {
        // Check if the password and confirm password match
        if ($password !== $confirm_password) {
            return false;
        }

        // Connect to the database
        $pdo = $this->db->connect();
        if ($pdo === null) {
            throw new Exception('Database connection failed');
        }

        // Check if the email already exists in the database
        if ($this->emailExists($pdo, $email)) {
            return false;
        }

        // Insert the new user into the database
        return $this->insertUser($pdo, $name, $email, $password);
    }

    /**
     * Authenticate a user
     *
     * @param string $email
     * @param string $password
     * @return array|null Returns the user data if the user was authenticated successfully, null otherwise
     */
    public function authenticateUser(string $email, string $password): ?array
    {
        // Get the user by email
        $user = $this->getUserByEmail($email);

        // Verify the password
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return null;
    }

    /**
     * Check if an email exists in the database
     *
     * @param PDO $pdo
     * @param string $email
     * @return bool Returns true if the email exists, false otherwise
     */
    private function emailExists(PDO $pdo, string $email): bool
    {
        // Prepare and execute the SQL query
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);

        // Check if the query returned a result
        return $stmt->fetch() !== false;
    }

    /**
     * Insert a new user into the database
     *
     * @param PDO $pdo
     * @param string $name
     * @param string $email
     * @param string $password
     * @return bool Returns true if the user was inserted successfully, false otherwise
     */
    private function insertUser(PDO $pdo, string $name, string $email, string $password): bool
    {
        // Prepare the SQL query
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        // Hash the password
        $passwordHash = password_hash($password, self::PASSWORD_ALGO);

        // Execute the query with the user data
        return $stmt->execute(['name' => $name, 'email' => $email, 'password' => $passwordHash]);
    }

    /**
     * Get a user by email
     *
     * @param string $email
     * @return array|null Returns the user data if the user was found, null otherwise
     */
    private function getUserByEmail(string $email): ?array
    {
        // Connect to the database
        $pdo = $this->db->connect();
        // Prepare and execute the SQL query
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        // Fetch the user data
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}