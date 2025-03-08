<?php
require_once __DIR__ . "/../connection/connection.php";
require_once __DIR__ . "/UserSkeleton.php";

class User extends UserSkeleton
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Function to create a new user
    public static function createUser($pdo, $username, $email, $password)
    {
        try {
            // Check if email already exists
            if (self::userExists($pdo, $email)) {
                return "Email already in use.";
            }
            // Check if all fields are provided
            if (empty($username) || empty($email) || empty($password)) {
                return "All fields are required.";
            }



            // Prepare the SQL query
            $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $pdo->prepare($sql);


            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => password_hash($password, PASSWORD_BCRYPT)
            ]);

            // Return the new user's ID
            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Function to check if a user already exists
    private static function userExists($pdo, $email)
    {
        $sql = "SELECT id FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
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
    public static function loginUser($pdo, $email, $password)
    {
        $sql = "SELECT id,username,password FROM users WHERE email=:email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }
}
