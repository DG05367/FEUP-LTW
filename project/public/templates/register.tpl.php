<?php
require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawRegister()
{ ?>

	<link rel="stylesheet" href="../css/format.css">
	<link rel="stylesheet" href="../css/style.css">

	<h1>Register</h1>
	<?php if (isset($_SESSION['register_error'])) {
		echo '<p style="color: red;">' . $_SESSION['register_error'] . '</p>';
		unset($_SESSION['register_error']);
	} ?>
	<form action="/public/actions/action_register.php" method="post" id=register_form>
		<label for="files">Profile picture(optional):</label>
		<input type="file" id="files" name="files"><br><br>

		<label for="name"><b>Name:</b></label><br>
		<input type="text" placeholder="Enter Name" name="name" required><br>

		<label for="username"><b>Username:</b></label><br>
		<input type="text" placeholder="Enter Username" name="username" required><br>

		<label for="email"><b>Email:</b></label><br>
		<input type="email" placeholder="Enter Email" name="email" required><br>

		<label for="password"><b>Password:</b></label><br>
		<input type="password" placeholder="Enter Password" name="password" required><br>

		<label for="password"><b>Re-enter Password:</b></label><br>
		<input type="password" placeholder="Enter Password" name="repeat_password" required><br>

		<input type="submit" value="Register">
	</form>
	</body>

	</html>

<?php } ?>