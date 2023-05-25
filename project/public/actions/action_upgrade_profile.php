<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/edit_clients.db.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/check_admin.db.php');

    $db = getDatabaseConnection();

    $clientId = Client::getId($db, $_GET['username']);
    $client = Client::getClient($db, $clientId);
    $perms = $_GET['perms'];

    if($perms == 'Admin'){
        $client->upgradeToAdmin($db);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else{
        $departmentId = intval($_GET['department']);
        $client->upgradeToAgent($db, $departmentId);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

?>