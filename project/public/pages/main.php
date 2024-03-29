<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/check_admin.db.php');
require_once(__DIR__ . '/../templates/common.tpl.php');

$db = getDatabaseConnection();

$isAdmin = checkAdmin($db, $session->getId());

drawHeader($session);
drawBody($isAdmin);
drawFooter();
