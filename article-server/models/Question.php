<?php
require_once __DIR__ . "/../connection/connection.php";
require_once __DIR__ . "/QuestionSkeleton.php";


class Question extends QuestionSkeleton
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    //function to get all questions
    public function getAllQuestions()
    {
        $sql = "SELECT * FROM questions";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //function to add a new question
    public function createQuestion()
    {
        try {
            // Check if the user has provided valid question and answer
            if (!$this->getQuestion() || !$this->getAnswer()) {
                return "Both question and answer are required.";
            }


            $sql = "INSERT INTO questions (question, answer, user_id) VALUES (:question, :answer, :user_id)";
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([
                ':question' => $this->getQuestion(),
                ':answer' => $this->getAnswer(),
                ':user_id' => $this->getUserId()
            ]);

            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // function to search for a specific question/topic
    public function searchQuestion($searchTerm)
    {
        try {
            $sql = "SELECT * FROM questions WHERE question LIKE :searchTerm";
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([':searchTerm' => "%" . $searchTerm . "%"]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }



}
