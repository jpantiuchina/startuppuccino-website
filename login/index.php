<?php 

	include '../assets/php/session.php'; 

	if ($userLogged) header('Location: ../');

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Startuppuccino - Login</title>
	</head>
	<body>

		<?php include '../assets/php/header.php'; ?>

		<?php if (isset($_POST['login'])){ ?>

			<?php include 'login.php'; ?>

		<?php } else { ?>

			<form action="" method="post">

				<input type="email" name="email" placeholder="Hello@startuppuccino.com" required/>
				<input type="password" name="password" placeholder="Password" required/>
				<input type="submit" name="login" value="Login" />
				<span><a href="../resetpassword/" target="_blank">Reset/Forgot Password</a></span>

			</form>

		<?php } ?>

		<?php include '../assets/php/footer.php'; ?>

	</body>
</html>