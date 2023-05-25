<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
$db = getDatabaseConnection();

$newStatus = $_POST['status'];

if (empty($newStatus)) {
    echo "Status cannot be empty.";
    exit;
}

try {
    // Prepare the SQL statement to insert the new status into the ticket_statuses table
    $stmt = $db->prepare('INSERT INTO ticket_status (status_name) VALUES (?)');
    $stmt->execute([$newStatus]);
    header("Location: /public/pages/admin.php");
    echo "New status '$newStatus' added successfully.";
    exit;
} catch (Exception $e) {
    echo "Failed to add status: " . $e->getMessage();
}
