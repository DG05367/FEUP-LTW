<?php

declare(strict_types=1);

require_once(__DIR__ . '/../public/utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../public/templates/common.tpl.php');
require_once(__DIR__ . '/../public/templates/login.tpl.php');

drawHeader($session);
drawLogin();
drawFooter();
