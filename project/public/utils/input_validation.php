<?php

function isUsernameValid($username)
{
    if (preg_match("/^[a-zA-Z0-9\.\_]+$/", $username)) {
        return true;
    }
    return false;
}

function isNameValid($input)
{
    if (preg_match("/^[a-zA-Z0-9\.\_\-\s\ç\Ç]+$/", $input)) {
        return true;
    }
    return false;
}

function isPasswordValid($password)
{
    // Check if the password meets the desired complexity requirements
    $hasUppercase = preg_match('/[A-Z]/', $password);
    $hasLowercase = preg_match('/[a-z]/', $password);
    $hasNumber = preg_match('/\d/', $password);
    $hasSpecialChar = preg_match('/[^A-Za-z0-9]/', $password);
    $length = strlen($password);

    // Return true if all complexity requirements are met
    return ($hasUppercase && $hasLowercase && $hasNumber && $hasSpecialChar && $length >= 7);
}

function isEmailValid($email)
{
    // Validate the email address
    $valid = filter_var($email, FILTER_VALIDATE_EMAIL);

    // Return true if the email is valid, false otherwise
    return $valid !== false;
}

function isTicketValid($input)
{
    if (preg_match("/^[a-zA-Z0-9\.\_\-\s\!\?\*]+$/", $input)) {
        return true;
    }
    return false;
}
