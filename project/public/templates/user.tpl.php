<?php

declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/department.db.php');
?>

<?php function drawProfile(PDO $db, Client $profile, Session $session)
{ ?>
    <h1>User Profile</h1>
    <img src="../images/profilepic.png" alt="User profile picture">

    <ul>
        <li><span class="boldpart">Name: </span> <?= $profile->name ?></li>
        <li><span class="boldpart">Username: </span> <?= $profile->username ?></li>
        <li><span class="boldpart">Email: </span> <?= $profile->email ?></li>
        <?php if (checkAgent($db, $profile->getClientId()) && !checkAdmin($db, $profile->getClientId())) { ?>
            <?php $department_id = $profile->getDepartmentIdClientSide($db) ?>
            <li><span class="boldpart">Department: </span><?= getDepartmentName($db, $department_id) ?></li>
            <li><span class="boldpart">Position: </span>Agent</li>
        <?php } ?>
        <?php if (checkAdmin($db, $profile->getClientId())) { ?>
            <?php $department_id = $profile->getDepartmentIdClientSide($db) ?>
            <li><span class="boldpart">Department: </span><?= getDepartmentName($db, $department_id) ?></li>
            <li><span class="boldpart">Position: </span>Admin</li>
        <?php } ?>
    </ul>
    <?php if (checkAgent($db, $session->getId()) && $session->getId() == $profile->client_id) { ?>
        <form action="../pages/agent_department_page.php">
            <input type="hidden" name="button" value="department">
            <button>See tickets from my department</button>
        </form><br>
        <form action="../pages/agent_tickets_page.php">
            <button>See tickets assigned to me</button>
        </form><br>
    <?php } ?>

    <?php if ($profile->client_id == $session->getId()) { ?>
        <form action="../pages/edit_profile.php">
            <button>Edit profile</button>
        </form><br>
    <?php } ?>

    <?php if (checkAdmin($db, $session->getId()) && $session->getId() != $profile->getClientId()) { ?>
        <?php if (checkAgent($db, $profile->getClientId()) && !checkAdmin($db, $profile->getClientId())) { ?>
            <form action="../actions/action_upgrade_profile.php">
                <input type="hidden" name="username" value="<?= $profile->getClientUsername() ?>">
                <input type="hidden" name="perms" value="Admin">
                <button>Upgrade profile to admin</button>
            </form><br>
        <?php } elseif (!checkAdmin($db, $profile->getClientId())) { ?>
            <form action="../actions/action_upgrade_profile.php">
                <select name="department">
                    <?php
                    $departments = getDepartments($db);
                    foreach ($departments as $department) {
                        $departmentId = $department['department_id'];
                        $departmentName = $department['name'];
                    ?>
                        <option value="<?= $departmentId ?>"><?= $departmentName ?></option>
                    <?php
                    } ?>
                </select>
                <input type="hidden" name="username" value="<?= $profile->getClientUsername() ?>">
                <input type="hidden" name="perms" value="Agent">
                <button>Upgrade profile to agent</button>
            </form><br>
        <?php } ?>

        <?php if (checkAdmin($db, $profile->getClientId())) { ?>
            <form action="../actions/action_downgrade_profile.php?username=<?= $profile->getClientUsername() ?>">
                <input type="hidden" name="username" value="<?= $profile->getClientUsername() ?>">
                <input type="hidden" name="perms" value="Agent">
                <button>Downgrade profile to Agent</button>
            </form><br>
        <?php } elseif (checkAgent($db, $profile->getClientId())) { ?>
            <form action="../actions/action_downgrade_profile.php?username=<?= $profile->getClientUsername() ?>">
                <input type="hidden" name="username" value="<?= $profile->getClientUsername() ?>">
                <input type="hidden" name="perms" value="Client">
                <button>Downgrade profile to Client</button>
            </form><br>
        <?php } ?>

    <?php } ?>

    <form action="../actions/action_delete_profile.php" method="post">
        <input type="hidden" name="username" value="<?= $profile->getClientUsername() ?>">
        <button>Delete Profile</button>
    </form>
<?php } ?>


<?php function drawEdit()
{ ?>
    <form action="../pages/edit_profile.php">
        <button>Edit profile</button>
    </form>
<?php } ?>


<?php function drawProfileForm(Client $client)
{ ?>

    <p>Change Profile Picture:</p>
    <form id="profileForm" action="" method="post" enctype="multipart/form-data">
        <input type="file" name="profilePicture" id="profilePicture">
        <button type="submit" id="uploadButton">Upload</button>
    </form>
    <script src="../javascript/uploadImage.js"></script>
    <br><br>
    <form action="../actions/action_edit_profile.php" method="post">
        <?php if (isset($_SESSION['name_error'])) : ?>
            <p class="error"><?= $_SESSION['name_error'] ?></p>
            <?php unset($_SESSION['name_error']); ?>
        <?php endif; ?>
        <label for="name"><b>New name:</b></label><br>
        <input id="name" type="text" placeholder="Enter name" name="name" value="<?= $client->name ?>"><br>

        <?php if (isset($_SESSION['username_error'])) : ?>
            <p class="error"><?= $_SESSION['username_error'] ?></p>
            <?php unset($_SESSION['username_error']); ?>
        <?php endif; ?>
        <label for="username"><b>New username:</b></label><br>
        <input type="text" placeholder="Enter Username" name="username" value="<?= $client->username ?>"><br>

        <?php if (isset($_SESSION['email_error'])) : ?>
            <p class="error"><?= $_SESSION['email_error'] ?></p>
            <?php unset($_SESSION['email_error']); ?>
        <?php endif; ?>
        <label for="email"><b>New Email:</b></label><br>
        <input type="email" placeholder="Enter Email" name="email" value="<?= $client->email ?>"><br>

        <?php if (isset($_SESSION['password_error'])) : ?>
            <p class="error"><?= $_SESSION['password_error'] ?></p>
            <?php unset($_SESSION['password_error']); ?>
        <?php endif; ?>
        <label for="password"><b>New password:</b></label><br>
        <input type="password" placeholder="Enter Password" name="password" value=""><br><br>

        <input type="submit" value="Submit changes">
    </form>


<?php } ?>