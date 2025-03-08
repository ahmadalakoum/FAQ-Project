<?php

// Require the database connection
require_once "../connection/connection.php";

$users = [
    ['username' => 'ahmad_al_akoum', 'email' => 'ahmad@example.com', 'password' => password_hash('a123', PASSWORD_BCRYPT)]
];

// Insert users into the `users` table
foreach ($users as $user) {
    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':username' => $user['username'],
        ':email' => $user['email'],
        ':password' => $user['password']
    ]);
    echo "Inserted user: " . $user['username'] . "\n";
}
$userId = $pdo->lastInsertId();

$questions = [
    ['question' => 'What is prompt engineering?', 'answer' => 'Prompt engineering is the process of designing input prompts to guide AI models like ChatGPT to generate relevant, structured, and high-quality responses.'],
    ['question' => 'Why is prompt engineering important?', 'answer' => 'It improves accuracy, enhances automation, saves time, and helps shape AI behavior.'],
    ['question' => 'What is an example of an effective prompt?', 'answer' => 'Instead of asking "Explain AI," a well-designed prompt would be: "Explain AI in simple terms, focusing on how it works, its applications, and future potential, in under 200 words."'],
    ['question' => 'What are prompt patterns?', 'answer' => 'Prompt patterns are structured templates or techniques that optimize AI interactions by ensuring consistency and reliability in responses.'],
    ['question' => 'What are the benefits of using prompt patterns?', 'answer' => 'They increase efficiency, ensure structured output, and reduce trial-and-error in AI-generated responses.'],
    ['question' => 'What are the five categories of prompt patterns?', 'answer' => 'Input Semantics – Defines how AI interprets input. Output Customization – Controls response format and style. Error Identification – Helps detect AI-generated mistakes. Prompt Improvement – Enhances question clarity. Interaction – Shapes user-AI engagement.'],
    ['question' => 'What is the Meta Language Creation pattern?', 'answer' => 'It allows users to define custom notations that AI understands, such as: "Whenever I type A → B, assume it means a directed graph with nodes A and B."'],
    ['question' => 'How does the Persona Pattern help in AI interactions?', 'answer' => 'It assigns AI a specific role or personality to provide expert-level responses, e.g., "Act as a cybersecurity expert and analyze this Python code for vulnerabilities."'],
    ['question' => 'What is the Output Automater Pattern used for?', 'answer' => 'It ensures AI generates automation tools, scripts, or workflows instead of plain text, ideal for software engineering and DevOps.'],
    ['question' => 'What is the Fact Check List Pattern?', 'answer' => 'It makes AI list key facts in its response to help users verify accuracy, useful for journalism and research.'],
    ['question' => 'How does the Question Refinement Pattern work?', 'answer' => 'AI suggests better versions of user questions for clarity, e.g., "Whenever I ask about software security, suggest a better version incorporating specific threats."'],
    ['question' => 'What is the Flipped Interaction Pattern?', 'answer' => 'AI asks the user questions before answering to gather more context, improving the quality of responses.'],
    ['question' => 'What is the Infinite Generation Pattern?', 'answer' => 'AI continuously generates content without needing repeated prompts, useful for brainstorming or content creation.'],
    ['question' => 'How do prompt patterns help in automating tasks?', 'answer' => 'The Output Automater and Infinite Generation patterns enable AI to generate structured outputs for complex tasks.'],
    ['question' => 'Which prompt pattern improves security?', 'answer' => 'The Persona (Security Expert) and Fact Check List patterns help in improving cybersecurity interactions.'],
    ['question' => 'How can prompt patterns enhance learning?', 'answer' => 'The Flipped Interaction and Game Play patterns encourage active learning by engaging users dynamically.'],
    ['question' => 'Which pattern is useful for generating visuals?', 'answer' => 'The Visualization Generator pattern helps AI generate descriptions that can be converted into images or diagrams.'],
    ['question' => 'How do prompt patterns assist in API usage?', 'answer' => 'The Question Refinement and Alternative Approaches patterns help users ask precise queries for better API responses.'],
    ['question' => 'What are the key benefits of prompt patterns?', 'answer' => 'Efficiency, accuracy, automation, and customizability in AI interactions.'],
    ['question' => 'What is the main takeaway from the report?', 'answer' => 'By understanding and applying prompt patterns, users can improve how they interact with AI models, leading to better, faster, and more precise responses.']
];


foreach ($questions as $question) {
    $sql = "INSERT INTO questions (question, answer, user_id) VALUES (:question, :answer, :user_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':question', $question['question']);
    $stmt->bindParam(':answer', $question['answer']);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    echo "Inserted question: " . $question['question'] . "\n";
}
