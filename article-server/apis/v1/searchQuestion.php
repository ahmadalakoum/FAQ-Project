<?php
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
    if (!isset($_GET['search'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'no search parameter provided'
        ]);
        exit();
    }
    //get the search param
    $searchTerm = trim($_GET['search']);

    if (empty($searchTerm)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'search term cannot be empty'
        ]);
        exit();
    }
    $questions = new Question($pdo);
    $response = $questions->searchQuestion($searchTerm);

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