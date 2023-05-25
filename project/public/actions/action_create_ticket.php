<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/create_tickets.db.php');
require_once(__DIR__ . '/../database/department.db.php');

$db = getDatabaseConnection();

$title = $_POST['title'];
$description = $_POST['description'];
$department = intval($_POST['department']);

createTicket($db, $title, $description, $department, $session->getId());
