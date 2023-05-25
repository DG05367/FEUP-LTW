<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/tag.class.php');

$db = getDatabaseConnection();

$ticketId = intval($_POST['ticket_id']);
$tagInput = $_POST['tagsInput'];

$tag = new Tag($ticketId, $tagInput);

$tag->addTag($db);

header('Location: ' . $_SERVER['HTTP_REFERER']);

?>