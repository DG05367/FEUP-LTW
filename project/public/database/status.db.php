<?php

declare(strict_types=1);

function getStatuses(PDO $db){
    $stmt = $db->prepare('SELECT status_id, status_name FROM ticket_status');
    $stmt->execute();
    
    $status = $stmt->fetchAll();

    return $status;
}

function getStatusName(PDO $db, int $status_id): ?string{
    $stmt = $db->prepare('SELECT status_name FROM ticket_status WHERE status_id = ?');
    $stmt->execute([$status_id]);

    $status = $stmt->fetch();

    return $status['status_name'];
}

?>