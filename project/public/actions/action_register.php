<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

include_once(__DIR__ . '/../utils/redirect.php');
include_once(__DIR__ . '/../utils/input_validation.php');
include_once(__DIR__ . '/../database/edit_clients.db.php');
include_once(__DIR__ . '/../database/user.class.php');

$db = getDatabaseConnection();

$name = $_POST['name'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$repeat_password = $_POST['repeat_password'];

// Check if both passwords match
if ($password !== $repeat_password) {
    die(redirect_register('error', 'Passwords do not match.'));
}

// Check if name has any invalid characters
if (!isNameValid($name)) {
    die(redirect_register('error', 'Invalid Name'));
}

// Check if the username has any invalid characters
if (!isUsernameValid($username)) {
    die(redirect_register('error', 'Invalid Username'));
}

// Check if the username is available
if (!availableUsername($username)) {
    die(redirect_register('error', 'Username already in use.'));
}

// Check if the email is valid
if (!isEmailValid($email)) {
    die(redirect_register('error', 'Invalid Email'));
}

// Check if the email is available
if (!availableEmail($email)) {
    die(redirect_register('error', 'Email already in use'));
}

// Check if the password is valid
if (!isPasswordValid($password)) {
    die(redirect_register('error', 'Password did not meet requirements'));
}

try {
    insertUser($name, $username, $email, $password);
    $session->setUsername($username);
    $session->setId(Client::getId($db, $session->getUsername()));
    $session->addMessage('success', 'Register successful!');
    header("Location: ../pages/main.php");
    exit();
} catch (PDOException $e) {
    $session->addMessage('error', 'Failed to register');
}
