<?php

declare(strict_types=1);

include_once(__DIR__ . '/../database/connection.db.php');


function insertUser(string $name, string $username, string $email, string $password)
{
    $db = getDatabaseConnection();

    $stmt = $db->prepare('INSERT INTO clients(name, username, email, password) VALUES(?, ?, ?, ?)');

    $stmt->execute(array($name, $username, $email, password_hash($password, PASSWORD_DEFAULT)));
}

function availableUsername($username)
{
    $db = getDatabaseConnection();

    $stmt = $db->prepare('SELECT * FROM clients WHERE username = ?');
    $stmt->execute(array($username));

    return $stmt->fetch() ? false : true;
}

function availableEmail($email)
{
    $db = getDatabaseConnection();

    $stmt = $db->prepare('SELECT * FROM clients WHERE email = ?');
    $stmt->execute(array($email));

    return $stmt->fetch() ? false : true;
}

function deleteClient(PDO $db, int $clientId)
{
    $stmt = $db->prepare('DELETE FROM clients WHERE client_id = :client_id');

    $stmt->bindParam(':client_id', $clientId);

    $stmt->execute();
}

function verifyCredentials($username, $password)
{
    $db = getDatabaseConnection();

    $stmt = $db->prepare('SELECT * FROM clients WHERE username = ?');
    $stmt->execute(array($username));

    $client = $stmt->fetch();

    return $client !== false && password_verify($password, $client['password']);
}

function changePassword($username, $new_password)
{
    $db = getDatabaseConnection();

    $stmt = $db->prepare('UPDATE clients SET password = ? WHERE username = ?');
    $stmt->execute(array(password_hash($new_password, PASSWORD_DEFAULT), $username));

    return $stmt->fetch();
}
