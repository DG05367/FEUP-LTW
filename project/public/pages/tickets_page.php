<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/check_admin.db.php');
require_once(__DIR__ . '/../database/tickets.class.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/ticket.tpl.php');

$db = getDatabaseConnection();

$filter = $_GET['filter'] ?? 'recent';

$tickets = Ticket::getTickets($db, 50, $filter);

$drawHeader = isset($_GET['filter']);

drawHeader($session);

drawTickets($db, $tickets, $session->getId(), $filter);

drawFooter();
