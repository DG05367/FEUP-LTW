<?php

declare(strict_types=1);

function checkAdmin(PDO $db, int $id)
{

    $query = "SELECT COUNT(*) FROM admins WHERE admin_id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    return $count > 0;
}

function checkAgent(PDO $db, int $id)
{

    $query = "SELECT COUNT(*) FROM agents WHERE agent_id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    return $count > 0;
}
