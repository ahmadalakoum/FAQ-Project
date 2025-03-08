<?php

class CreateQuestionsTable
{
    public function up($pdo)
    {
        $sql = "CREATE TABLE IF NOT EXISTS questions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        question VARCHAR(255) NOT NULL,
        answer VARCHAR(255) NOT NULL,
        user_id INT,
        FOREIGN KEY (user_id) REFERENCES users(id)
        )";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function down($pdo)
    {
        $sql = "DROP TABLE IF EXISTS questions";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }
}