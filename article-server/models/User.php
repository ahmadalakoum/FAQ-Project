<?php
require_once "../connection/connection.php";
require_once "./UserSkeleton.php";

class User extends UserSkeleton
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Function to create a new user
    public function createUser()
    {
        try {
            // Check if email already exists
            if ($this->userExists()) {
                return "Error: Email already in use.";
            }


            // Prepare the SQL query
            $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $this->pdo->prepare($sql);


            $stmt->execute([
                ':username' => $this->getUsername(),
                ':email' => $this->getEmail(),
                ':password' => password_hash($this->getPassword(), PASSWORD_BCRYPT)
            ]);

            // Return the new user's ID
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Function to check if a user already exists
    private function userExists()
    {
        $sql = "SELECT id FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $this->getEmail()]);
        return $stmt->fetchColumn() ? true : false;
    }

    //function to update a user
    public function updateUser()
    {
        try {
            $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':username' => $this->getUsername(),
                ':email' => $this->getEmail(),
                ':id' => $this->getId()
            ]);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    //function to login a user
    public function loginUser($email, $password)
    {
        $sql = "SELECT id,username,password FROM users WHERE email=:email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email', $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }
}
