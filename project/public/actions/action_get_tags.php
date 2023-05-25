<?php

require_once(__DIR__ . ' /../database/connection.db.php');
require_once(__DIR__ . '/../database/tag.class.php');

$db = getDatabaseConnection();

$input = json_decode(file_get_contents('php://input'), true)['input'];

echo var_dump($input);

if (isset($input)) {
    $tags = getTagsMatch($db, $input);
    echo json_encode($tags);
}
