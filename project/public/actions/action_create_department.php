<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/department.db.php');

$db = getDatabaseConnection();

$new_department = $_POST['department_name'];

createDepartment($db, $new_department);
