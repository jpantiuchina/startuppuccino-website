<?php

	require '../assets/php/session.php';

	// Redirect to home if user is not logged
	if(!$userLogged) header("Location: ../");

	// Include and Initialize People Functions
	require_once '../assets/php/People_Functions.php';
	$people_func = new People_Functions($_SESSION['id']);

?>

<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../assets/css/form.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/general.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/listview.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/people.css">
		<title>People - Startuppuccino</title>

	</head>
	<body>
		
		<?php include '../assets/php/header.php'; ?>

		<?php
			
			/* If isset the get parameter 'user_id' ( ../index.php?user_id=xxxx )
			links like ../people/xxxx are manage with .htaccess and loaded the content as the sintax above ( with GET parameter )
			then the user details are diplayed instead of the list of users and mentors */
		

		if (isset($_GET['user_id'])){

			// User profile details

			// Set the account_id of the person to show
			$people_func->setPerson($_GET['user_id']);

			// Get the person info
			if ($person = $people_func->getPersonInfo()) {

		        echo $person["firstname"] . " " . $person["lastname"] . "<br>";
		        echo $person["role"] . "<br>";
		        echo "<img src='../assets/pics/" . $person["avatar"] . "' />";
		        echo $person["email"] . "<br>";
		        echo $person["about"] . "<br>";
				
				// Check if we are looking at our profile
		        if($people_func->isMyProfile()) {
		        	echo "<div class='button button--big'><a href='./account/'>Edit Profile</a></div>";
		        }

			} else {
			    echo "Nobody is here!";
			}

		} else {

			// People list

			?>

			<!-- Display filter for only students|mentors -->
			<div class="filter_menu filter_menu--people">
				<span class="filter_menu__button" id="filter_button--STUDENT" onclick="filterResults('STUDENT',this)">Students</span>
				<span class="filter_menu__button" id="filter_button--MENTOR" onclick="filterResults('MENTOR',this)">Mentors</span>
				<span class="filter_menu__button" id="filter_button--ALL" onclick="removeFilters()">All</span>
			</div>

			<br><br>

			<div class="list_view list_view--linear" id="people_wrapper">

				<?php

					if ($people = $people_func->getAllPeople()){

						foreach ($people as $person){
						
					        ?>

						        <div class="card card--<?php print strtoupper($person['role']); ?>">

						        	<a href="./?user_id=<?php print $person['id']; ?>">
							        	
							        	<!-- card content -->
							        	<div class="card__pic" 

							        		<?php
							        			
							        			$pic_name = "../assets/pics/".$person['avatar'];

							        			if(trim($person['avatar'])!="" && file_exists($pic_name)){
								        			// set the user picture
								        			echo 'style="background-image:url(\'' . $pic_name . '\')"';
							        			} else {
							        				// set the default picture
								        			echo 'style="background-image:url(\'../assets/pics/default/people.png\');/*background-size:190px 190px;*/opacity:0.4"';
								        		}

							        		?>

							        	></div>
							        	<div class="card__details">
						        			<span class="card__details_name">
							        			<?php print $person['firstname'] . " " . $person['lastname']; ?>
							        		</span>
							        		<span class="card__details_role">
							        			<?php print strtoupper($person['role']); ?>
							        		</span>
							        		<span class="card__details_background">
							        			<?php print $person['background']; ?>
							        		</span>
							        	</div>

							        </a>

								</div>

					        <?php

					    }

					} else {
					    echo "Nobody is here!";
					}

				?>

			<div class="change_view_button" onclick="toggleLayout()">
				<img src="../assets/pics/default/listico.png" id="change_view_icon">
			</div>

			</div>

		<?php } // endif switch all users list or single user details ?>

		<?php include '../assets/php/footer.php'; ?>


		<script src="../assets/js/people.js"></script>

	</body>
</html>