<?php include './assets/php/session.php'; ?> 

<!DOCTYPE html>
<html>
	<head>
		
		<title>Startuppuccino</title>

	</head>
	<body>

		<a href="./people/">People</a>

		<hr>

		<?php if ($userLogged){ ?>

			<h1>Hello <?php print $_SESSION['firstname']; ?>!</h1>

			<br>

			<a href="./account/">My account</a>

			<br/><br/>

			<a href="./logout/">Logout</a>

		<?php } else { ?>

			<!-- change this into a login form (external ajax login form script -> include) -->
			<a href="./login/">Login</a>

			<br>
			<br>
			<hr>
			<br>

			<a href="./signup/">Sign up</a>

		<?php } // endif userlogged ?>

	</body>
</html>