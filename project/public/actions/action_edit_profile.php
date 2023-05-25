<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!($session->isLoggedIn())) die(header('Location: /'));

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../utils/input_validation.php');

$db = getDatabaseConnection();

$client = Client::getClient($db, $session->getId());

if ($client) {
  $client->name = $_POST['name'];
  if (!empty($client->name)) {
    if (isNameValid($client->name)) {
      $client->changeName($db);
    } else {
      $_SESSION['name_error'] = "Name is invalid.";
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    }
  }
  $client->email = $_POST['email'];
  if (!empty($client->email)) {
    if (isEmailValid($client->email)) {
      $client->changeEmail($db);
    } else {
      $_SESSION['email_error'] = "Email is invalid.";
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    }
  }
  $client->username = $_POST['username'];
  if (!empty($client->username)) {
    if (isUsernameValid($client->username)) {
      $client->changeUsername($db);
      $session->setUsername($client->username);
    } else {
      $_SESSION['username_error'] = "Username is invalid.";
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    }
  }
  $client->password = $_POST['password'];
  if (!empty($client->password)) {
    if (isPasswordValid($client->password)) {
      $client->changePassword($db);
    } else {
      $_SESSION['password_error'] = "Password doesn't meet criteria
      (atleast 1 number, 1 lowercase letter, 1 uppercase letter and a
      special character).";
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit();
    }
  }
}

header('Location: ../pages/profile.php?username=' . urlencode($session->getUsername()));
