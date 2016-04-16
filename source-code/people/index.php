<?php

	include '../assets/php/session.php';

	include '../assets/php/db_connect.php';

	// Redirect to home if user is not logged
	if(!$userLogged) header("Location: ../");

?>

<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../assets/css/form.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/general.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/listview.css">
		<title>People - Startuppuccino</title>

	</head>
	<body>
		
		<?php include '../assets/php/header.php'; ?>

		<?php
			 /* If isset the get parameter 'user_id' ( ../index.php?user_id=xxxx )
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
			<div class="filter_menu filter_menu--people">
				<li class="filter_menu__button" id="filter_button--STUDENT" onclick="filterResults('STUDENT',this)">Students</li>
				<li class="filter_menu__button" id="filter_button--MENTOR" onclick="filterResults('MENTOR',this)">Mentors</li>
			</div>

			<br><br>

			<div class="list_view">

				<?php

					if (mysqli_num_rows($people) > 0){

						//echo mysqli_num_rows($people);

						foreach ($people as $person){
						
					        ?>

						        <div class="card card--<?php print strtoupper($person['role']); ?>">

						        	<!-- card content -->
						        	<div class="card__details--brown">
						        		<a href="./?user_id=<?php print $person['id']; ?>">
							        		<span class="card__details_name">
							        			<?php print $person['firstname'] . " " . $person['lastname']; ?>
							        		</span>
							        		<span class="card__details_role">
							        			<?php print strtoupper($person['role']); ?>
							        		</span>
							        		<span class="card__details_background">
							        			<?php print $person['background']; ?>
							        		</span>
						        		</a>
						        	</div>
						        	<div class="card__details_pic" 

						        		<?php
						        			
						        			$pic_name = "../assets/pics/".$person['avatar'];

						        			if(trim($person['avatar'])!="" && file_exists($pic_name)){
							        			// set the user picture
							        			echo 'style="background-image:url(\'' . $pic_name . '\')"';
						        			} else {
						        				// set the default picture
							        			echo 'style="background-image:url(\'../assets/pics/default/people.png\');background-size:190px 190px"';
							        		}

						        		?>

						        	></div>

								</div>

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


		<script src="../assets/js/people.js"></script>

	</body>
</html>

