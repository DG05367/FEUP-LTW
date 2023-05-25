<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

$db = getDatabaseConnection();

$agentId = $_POST['agent_id'];
$departmentId = $_POST['department_id'];

assignAgentToDepartment($db, $agentId, $departmentId);
