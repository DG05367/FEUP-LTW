<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/edit_clients.db.php');
require_once(__DIR__ . '/../database/user.class.php');

$db = getDatabaseConnection();

$clientId = Client::getId($db, $_POST['username']);

deleteClient($db, $clientId);

if ($clientId == $_SESSION['id']) {
    header("location: ../pages/initial_page.php");
    exit();
}

header("location: ../pages/main.php");
