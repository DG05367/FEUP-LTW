<?php

declare(strict_types=1);
function deleteTicket(PDO $db, string $ticketId)
{
    $stmt = $db->prepare('DELETE FROM tickets WHERE ticket_id = :ticket_id');

    $stmt->bindParam(':ticket_id', $ticketId);

    $stmt->execute();
}
