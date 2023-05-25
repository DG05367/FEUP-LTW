<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

include_once(__DIR__ . '/../utils/redirect.php');
include_once(__DIR__ . '/../utils/input_validation.php');
include_once(__DIR__ . '/../database/edit_clients.db.php');
include_once(__DIR__ . '/../database/user.class.php');

$db = getDatabaseConnection();

$username = $_POST['username'];
$password = $_POST['password'];

// Check if Username is valid
if (!isUsernameValid($username)) {
    die(redirect_login('error', 'Username: Invalid characters!'));
}

// Check if Password is valid
if (!isPasswordValid($password)) {
    die(redirect_login('error', 'Password: Invalid characters!'));
}

// Perform Credential verification for login
if (verifyCredentials($username, $password)) {
    $session->setUsername($username);
    $session->setId(Client::getId($db, $session->getUsername()));
    $session->addMessage('success', 'Login successful!');
    header("Location: ../pages/main.php?user=" . urlencode($username));
    exit();
} else {
    $session->addMessage('error', 'Wrong password!');
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
