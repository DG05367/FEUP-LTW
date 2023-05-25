<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
$db = getDatabaseConnection();

$ticket_id = $_POST['ticket_id'];
$newStatus = $_POST['status'];

try {
    $stmt = $db->prepare('UPDATE tickets SET status_id = ? WHERE ticket_id = ?');
    $stmt->execute([$newStatus, $ticket_id]);
    header("Location: " . $_SERVER['HTTP_REFERER']);
    echo "Status changed to '$newStatus' successfully.";
    exit();
} catch (Exception $e) {
    echo "Failed to change status: " . $e->getMessage();
}
