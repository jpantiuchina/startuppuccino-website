<?php

	include '../assets/php/session.php';

	include '../assets/php/db_connect.php';

?>

<!DOCTYPE html>
<html>
	<head>

		<title><?php print $_SESSION['firstname']." ".$_SESSION['lastname']; ?> - Startuppuccino</title>
	
	</head>
	<body>
		
		<?php include '../assets/php/header.php'; ?>

		<?php
			 /* If isset the get parameter 'user' ( ../people.php?user_id=xxxx )
			 links like ../people/xxxx are manage with .htaccess and loaded the content as the sintax above ( with GET parameter )
			 then the user details are diplayed instead of the list of users and mentors */
		?>

		<?php if (isset($_GET['user_id'])){ ?>

			<!-- User profile details -->

			<?php $profile_view = mysqli_query($dbconn, "SELECT about, avatar, background, email, firstname, lastname, role FROM Account WHERE id='" . $_GET['user_id'] . "' "); ?>

			<?php

				if (mysqli_num_rows($profile_view) == 1) {

				    while($row = mysqli_fetch_assoc($profile_view)) {
				        echo $row["firstname"] . " " . $row["lastname"] . "<br>";
				        echo $row["role"] . "<br>";
				        echo "<img src='../assets/pics/" . $row["avatar"] . "' />";
				        echo $row["email"] . "<br>";
				        echo $row["about"] . "<br>";
				    }

				} else {
				    echo "Nobody is here!";
				}

				mysqli_close($dbconn);

			?>


		<?php } else { ?>

			<!-- People list -->

			<?php $people = mysqli_query($dbconn, "SELECT id, firstname, lastname, avatar, background, role FROM Account"); ?>

			<!-- Display filter for only students|mentors -->
			<nav>
				<li>Students</li>
				<li>Mentors</li>
			</nav>

			<br><br>

			<div class="list_view">

				<?php

					if (mysqli_num_rows($people) > 0) {

					    while($person = mysqli_fetch_assoc($people)) {
					        
					        ?>

						        <div class="user_card user_card--<?php print $person['role']; ?>">

						        	<!-- card content -->
						        	<div class="user_card__pic" style="background-image:url('../assets/pics/<?php print $person['avatar']; ?>')"></div>
						        	<div class="user_card__details">
						        		<span class="user_card__name">
						        			<?php print $person['firstname'] . " " . $person['lastname']; ?>
						        		</span>
						        		<span>
						        			<?php print $person['background']; ?>
						        		</span>
						        	</div>

								</div>

								<hr>

					        <?php

					    }

					} else {
					    echo "Nobody is here!";
					}

					mysqli_close($dbconn);

				?>

			</div>

		<?php } // endif switch all users list or single user details ?>

		<?php include '../assets/php/footer.php'; ?>

	</body>
</html>

