<?php
header("Content-Type: application/json");

require "../../connection/connection.php";
require "../../models/User.php";

$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $username = trim($data['username']);
    $email = trim($data['email']);
    $password = trim($data['password']);

    if (empty($username) || empty($email) || empty($password)) {
        echo json_encode(['status' => 'Error', 'message' => 'All fields are required']);
        exit();
    }

    $user = new User($pdo);
    $user->setUsername($username);
    $user->setEmail($email);
    $user->setPassword($password);

    $response = $user->createUser();

    if (is_numeric($response)) {
        echo json_encode([
            'status' => "success",
            "userId" => $response,
            "message" => "User created Successfully"
        ]);
    } else {
        echo json_encode(['status' => 'error', "message" => $response]);
    }
}

