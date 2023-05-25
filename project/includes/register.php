<?php

declare(strict_types=1);

require_once(__DIR__ . '/../public/utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../public/templates/common.tpl.php');
require_once(__DIR__ . '/../public/templates/register.tpl.php');

drawHeader($session);
drawRegister();
drawFooter();
