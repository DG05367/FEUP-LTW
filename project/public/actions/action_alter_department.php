<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/tickets.class.php');

$db = getDatabaseConnection();

$ticketId = intval($_POST['ticket_id']);
$department = intval($_POST['department']);
$ticket = Ticket::getTicket($db, $ticketId);

$ticket->alterDepartment($db, $department);
$ticket = Ticket::getTicket($db, $ticketId);

header('Location: ' . $_SERVER['HTTP_REFERER']);

?>