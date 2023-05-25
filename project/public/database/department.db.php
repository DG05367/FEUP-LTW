<?php

function createDepartment(PDO $db, string $department_name)
{
    $stmt = $db->prepare('INSERT INTO departments (name) VALUES (:name)');

    $stmt->bindParam(':name', $department_name);

    try {
        $stmt->execute();
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $_SESSION['create_error'] = "Department already exists.";
        } else {
            $_SESSION['create_error'] = 'Something went wrong.';
        }
    }
    header("Location: ../pages/admin.php");
    exit();
}

function getDepartmentName(PDO $db, int $id) : ?string{
    $stmt = $db->prepare('SELECT name FROM departments WHERE department_id = ?');

    $stmt->execute(array($id));

    $department = $stmt->fetch(PDO::FETCH_ASSOC);

    return $department['name'];
}

function checkDepartment(PDO $db, $id)
{
    $query = "SELECT COUNT(*) FROM departments WHERE department_id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    return $count > 0;
}

function getDepartments(PDO $db){
    $stmt = $db->prepare('SELECT department_id, name FROM departments');
    $stmt->execute();

    $departments = $stmt->fetchAll();

    return $departments;
}

function getDepartmentId(PDO $db, string $dep_name): ?int{
    $stmt = $db->prepare('SELECT department_id from departments WHERE name = ?');
    $stmt->execute([$dep_name]);
    $dep = $stmt->fetch(PDO::FETCH_ASSOC);

    return intval($dep['department_id']);
}
?>
