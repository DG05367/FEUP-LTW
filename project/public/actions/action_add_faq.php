<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../utils/input_validation.php');

$db = getDatabaseConnection();

try {
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    if (empty($question) || empty($answer)) {
        throw new Exception("Question and answer are required fields.");
    }

    // Insert new FAQ into the database
    $query = "INSERT INTO FAQs (question, answer) VALUES (:question, :answer)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':question', $question, PDO::PARAM_STR);
    $stmt->bindParam(':answer', $answer, PDO::PARAM_STR);
    $stmt->execute();


    header("Location: /public/pages/faqs.php");
    exit;
} catch (PDOException $e) {
    $_SESSION['error'] = "Something happened";
    echo "Failed to add FAQ: " . $e->getMessage();
}
