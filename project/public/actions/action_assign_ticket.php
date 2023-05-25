<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/tickets.class.php');
require_once(__DIR__ . '/../database/user.class.php');

$db = getDatabaseConnection();

$ticketId = intval($_GET['ticket_id']);
$ticket = Ticket::getTicket($db, $ticketId);

if(isset($_GET['username'])){
    $username = $_GET['username'];
    $agentId = Client::getId($db, $username);
    if($agentId == null){
        $_SESSION['username_error'] = 'username not valid';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    $ticket->AssignTicket($db, $agentId);
} else {
    $ticket->AssignTicket($db, $session->getId());
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
