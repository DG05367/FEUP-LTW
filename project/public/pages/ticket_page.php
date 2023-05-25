<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/check_admin.db.php');
require_once(__DIR__ . '/../database/tickets.class.php');
require_once(__DIR__ . '/../database/comment.class.php');
require_once(__DIR__ . '/../database/tag.class.php');
require_once(__DIR__ . '/../templates/tag.tpl.php');
require_once(__DIR__ . '/../templates/comment.tpl.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/ticket.tpl.php');

$db = getDatabaseConnection();

if (isset($_GET['id']) && !empty($_GET['id'])) {
  $ticketId = intval($_GET['id']);
  $ticket = Ticket::getTicket($db, $ticketId);
  $comments = Comment::getCommentsWithTicketId($db, $ticketId);
  $tags = Tag::getTagsWithTicketId($db, $ticketId);
}

drawHeader($session);
drawTicket($ticket, $db, $session);
drawTags($tags, $db, $ticketId);
drawComments($comments);
drawCreateNewComment($ticketId);
drawFooter();
