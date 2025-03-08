<?php
header("Content-Type: application/json");

require "../../connection/connection.php";
require "../../models/Question.php";
require "./getBearer.php";
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    //check if the user is logged in
    $userID = getBearerToken();
    if (!$userID) {
        echo json_encode([
            'status' => 'error',
            "message" => "Unauthorized"
        ]);
        exit();
    }

    //retrieve the question and the answer
    $question = trim($data['question']);
    $answer = trim($data['answer']);

    if (empty($question) || empty($answer)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'All fields are required'
        ]);
        exit();
    }

    $newQuestion = new Question($pdo);
    $newQuestion->setQuestion($question);
    $newQuestion->setAnswer($answer);
    $newQuestion->setUserId($userID);
    $response = $newQuestion->createQuestion();

    if (is_numeric($response)) {
        echo json_encode([
            'status' => "success",
            "questionId" => $response,
            "message" => "Question created Successfully"
        ]);
    } else {
        echo json_encode(['status' => 'error', "message" => $response]);
    }

}