<?php

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

include_once(__DIR__ . '/../utils/redirect.php');
include_once(__DIR__ . '/../utils/input_validation.php');
include_once(__DIR__ . '/../database/user.class.php');


$username = $_SESSION['username'];
if ($username == null) {
    die(redirect_login('error', 'Please log in to change your password'));
}

$old_password = $_POST['old_password'];
if (!isPasswordValid($old_password)) {
    die(redirect('error', 'Password contains invalid characters.'));
}
if (!verifyCredentials($username, $old_password)) {
    die(redirect('error', 'Invalid password.'));
}

$new_password = $_POST['new_password'];
$rep_password = $_POST['rep_password'];

// check if the old password and the confirmation one are equal
if ($new_password != $rep_password) {
    die(redirect('error', 'New passwords don\'t match!'));
}
if (!isPasswordValid($new_password)) {
    die(redirect('error', 'Invalid password'));
}

changePassword($username, $new_password);
die(redirect('success', 'Password changed successfully!'));
