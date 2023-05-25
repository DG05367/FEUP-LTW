<?php
require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawAdmin()
{ ?>

    <link rel="stylesheet" href="../css/format.css">
    <link rel="stylesheet" href="../css/style.css">

    <h1>Create new department </h1>
    <?php if (isset($_SESSION['create_error'])) {
        echo '<p style="color: red;">' . $_SESSION['create_error'] . '</p>';
        unset($_SESSION['create_error']);
    } ?>
    <form action="../actions/action_create_department.php" method="post" id=create_department>
        <label for="name">Insert name of new department:</label>
        <input type="text" id="department_name" name="department_name" required>
        <input type="submit" value="Submit">
    </form>

    <form method="POST" action="/public/actions/action_create_status.php">
        <label for="status">New Status:</label>
        <input type="text" id="status" name="status" required>
        <button type="submit">Create Status</button>
    </form>

<?php } ?>