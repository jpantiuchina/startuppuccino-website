<?php

	include '../assets/php/session.php';

	include '../assets/php/db_connect.php';

	if(!$userLogged) die("What are you doning here? :(");

?>

<!DOCTYPE html>
<html>
	<head>

		<title><?php print $user; ?> - Startuppuccino</title>
	
	</head>
	<body>
		
		<?php include '../assets/php/header.php'; ?>

		<!-- Account details -->

		<?php $profile_view = mysqli_query($dbconn, "SELECT about, avatar, background, email, firstname, lastname, role FROM Account WHERE id='" . $_SESSION['id'] . "' "); ?>

		<?php

			if (mysqli_num_rows($profile_view) == 1) {

			    while($row = mysqli_fetch_assoc($profile_view)) {

			    	?>

					<form action="" method="post" onsubmit="return checkForm();">

						<label>Email</label>
						<input type="email" name="email" placeholder="hello@startuppucino.com" required/>

						<label>Password</label>
						<input type="password" name="password" required/>

						<label>Repeat Password</label>
						<input type="password" name="password1" required/>

						<label>Firstname</label>
						<input type="text" name="firstname" required/>

						<label>Lastname</label>
						<input type="text" name="lastname" required/>

						<label>Background</label>
						<input type="text" name="background" placeholder="e.g. IT, design, law, economics, management" required/>

						<label>About me (optional)</label>
						<textarea name="about" placeholder="More info about me, about my startup idea, etc."></textarea>

						<label>Role</label>
						<label><input type="radio" name="role" value="user" required/>User (I'm here to learn)</label>
						<label><input type="radio" name="role" value="mentor" required/>Mentor (I'm here to help)</label>

						<!--
						<label>Photo (optional)</label>
						<input type="file" name="photo" />
						-->
						
					</form>

			        <?php
			    }

			} else {
			    echo "Nobody is here!";
			}

			mysqli_close($dbconn);

		?>

		<?php include '../assets/php/footer.php'; ?>

	</body>
</html>

