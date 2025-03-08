<?php
header("Content-Type: application/json");

require "../../connection/connection.php";
require "../../models/Question.php";
require "./getBearer.php";
if ($_SERVER['REQUEST_METHOD'] === "GET") {
    //check if the user is logged in
    $userID = getBearerToken();
    if (!$userID) {
        echo json_encode([
            'status' => 'error',
            "message" => "Unauthorized"
        ]);
        exit();
    }

    $questions = new Question($pdo);
    $response = $questions->getAllQuestions();

    if ($response) {
        echo json_encode([
            "status" => "success",
            "questions" => $response
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No Questions found'
        ]);
    }

}