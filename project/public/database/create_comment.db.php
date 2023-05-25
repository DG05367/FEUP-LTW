<?php

function createComment(PDO $db, string $comment, int $client_id, int $ticket_id)
{


    $stmt = $db->prepare('INSERT INTO comments (ticket_id, agent_id, comment, created_at) VALUES (:ticket_id, :agent_id, :comment, :created_at)');

    $created_at = date('Y-m-d H:i:s');

    $stmt->bindParam(':agent_id', $client_id);
    $stmt->bindParam(':comment', $comment);
    $stmt->bindParam(':ticket_id', $ticket_id);
    $stmt->bindParam(':created_at', $created_at);

    if ($stmt->execute()) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo 'Failed to add comment';
    }
}
