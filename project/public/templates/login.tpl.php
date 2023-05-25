<?php
require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawLogin()
{ ?>
    <h1>Clothes Tickets</h1>
    <form action="/public/actions/action_login.php" method="post" class="login">
        <?php if (isset($_SESSION['login_error'])) {
            echo '<p style="color: red;">' . $_SESSION['login_error'] . '</p>';
            unset($_SESSION['login_error']);
        } ?>
        <input type="username" name="username" placeholder="username">
        <input type="password" name="password" placeholder="password">
        <button type="submit">Login</button>
    </form>

    <p>¿Don't have an account yet? </p>
    <a href="register.php">Register</a>



    </body>

    </html>
<?php } ?>
