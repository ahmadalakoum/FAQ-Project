<?php
header("Content-Type: application/json");
require "./cors.php";
require "../../connection/connection.php";
require "../../models/User.php";

$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = trim($data['email']);
    $password = trim($data['password']);

    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'Error', 'message' => 'All fields are required']);
        exit();
    }

    $user = new UserSkeleton($username, $email, $password);

    $response = User::loginUser($pdo, $email, $password);

    if ($response) {
        echo json_encode([
            'status' => "success",
            "message" => "User Logged In",
            "username" => $response['username'],
            "id" => $response['id']
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Incorrect Credentials'
        ]);
    }
}