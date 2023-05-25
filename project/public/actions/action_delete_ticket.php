<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/remove_ticket.db.php');

$db = getDatabaseConnection();

$ticketId = $_POST['ticket_id'];

deleteTicket($db, $ticketId);

header('Location: ' . $_SERVER['HTTP_REFERER']);
