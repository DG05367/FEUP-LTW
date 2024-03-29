<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/user.tpl.php');

$db = getDatabaseConnection();

$clientId = Client::getId($db, $_GET['username']);
$client = Client::getClient($db, $clientId);

drawHeader($session);
drawProfile($db, $client, $session);
drawFooter();
