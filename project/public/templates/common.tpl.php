<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/check_admin.db.php');


$db = getDatabaseConnection();

$isAdmin = checkAdmin($db, 2)
?>

<?php function drawHeader(Session $session)
{ ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Main page</title>
        <link rel="stylesheet" href="../css/format.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body>
        <header>
            <?php
            if ($session->isLoggedIn()) drawLogoutHeader($session);
            else drawLoginHeader();
            ?>

        </header>

        <main>
        <?php } ?>

        <?php function drawFooter()
        { ?>
        </main>
        <link rel="stylesheet" href="../css/format.css">
        <link rel="stylesheet" href="../css/style.css">
        <footer>
            Ticket solving problem group 6 turma 5 2023
        </footer>
    </body>

    </html>
<?php } ?>


<?php function drawBody(bool $isAdmin)
{ ?>

    <link rel="stylesheet" href="../css/format.css">
    <link rel="stylesheet" href="../css/style.css">

    <form action="../pages/form.php">
        <button>Create new ticket</button>
    </form>

    <form action="../pages/tickets_page.php">
        <button>See all tickets</button>
    </form>

    <?php
    if ($isAdmin) { ?>
        <form action="../pages/admin.php">
            <button>Go to admin page</button>
        </form>
    <?php }
    ?>

<?php } ?>

<?php function drawInitialPage()
{ ?>

    <link rel="stylesheet" href="../css/format.css">
    <link rel="stylesheet" href="../css/style.css">

    <header>
        <h1>Clothes4U</h1>
        <img src="../images/logo.jpg" alt="">
    </header>

    <form action="/includes/login.php">
        <button>Login</button>
    </form>

    <form action="/includes/register.php">
        <button>Register</button>
    </form>



<?php } ?>

<?php function drawLoginHeader()
{ ?>
    <h1><a href="<?php echo BASE_URL; ?>">Clothes4U</a></h1>
    <img src="../images/logo.jpg" alt="">
<?php } ?>

<?php function drawLogoutHeader(Session $session)
{
?>
    <ul>
        <li><a href="../pages/faqs.php">FAQ</li>
        <li><a href="../pages/profile.php?username=<?= $session->getUsername() ?>">
                <?= $session->getUsername() ?></a></li>
        <li><a href="../actions/action_logout.php">Logout</a></li>
    </ul>
    <h1><a href="<?php echo BASE_URL; ?>">Clothes4U</a></h1>
    <img src="../images/logo.jpg" alt="">
<?php } ?>
