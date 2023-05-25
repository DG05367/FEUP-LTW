<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/create_comment.db.php');

$db = getDatabaseConnection();

$comment = $_POST['comment'];
$ticketId = intval($_GET['ticket_id']);

createComment($db, $comment, $session->getId(), $ticketId);
