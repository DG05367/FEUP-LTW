<?php

function createTicket(PDO $db, string $title, $description, int $department_id, int $client_id)
{
    $status = 1;

    $stmt = $db->prepare('INSERT INTO tickets (client_id, department_id, title, description, created_at, status_id) VALUES (:client_id, :department_id, :title, :description, :created_at, :status)');

    $created_at = date('Y-m-d H:i:s');

    $stmt->bindParam(':client_id', $client_id);
    $stmt->bindParam(':department_id', $department_id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':created_at', $created_at);
    $stmt->bindParam(':status', $status);

    // Execute the statement
    if ($stmt->execute()) {
        header('Location: ../pages/main.php');
    } else {
        echo 'Failed to add ticket';
    }
}
