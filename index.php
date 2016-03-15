<?php include './assets/php/session.php'; ?> 

<!DOCTYPE html>
<html>
	<head>
		
		<title>Startuppuccino</title>

	</head>
	<body>

		<?php if ($userLogged){ ?>

			<h1>Hello <?php print $user; ?></h1>

		<?php } else { ?>

			<!-- change this into a login form (external ajax login form script -> include) -->
			<button>Login</button>

			<a href="./signup/">Sign up</a>

		<?php } // endif userlogged ?>

	</body>
</html>