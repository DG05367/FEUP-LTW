<?php
require_once(__DIR__ . '/public/utils/session.php');
$session = new Session();

//header('Location: /public/pages/main.php');

if ($session->getUsername() != null) {
    header('Location: /public/pages/main.php');
    exit();
} else {
    header('Location: /includes/login.php');
    exit();
}
