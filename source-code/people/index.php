<?php

	require '../assets/php/session.php';

	// Redirect to home if user is not logged
	if(!$userLogged){
		header("Location: ../");
		exit;
	}

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

			?>

			<div class="profile_wrapper">

				<?php

				// Get the person info
				if ($person = $people_func->getPersonInfo()) {

					?>

					<section>
						
						<img class="profile_pic" src="../assets/pics/people/<?php echo $person['avatar']; ?>">

						<div class="profile_head">
							<h3 class="profile_name"><?php echo trim($person["firstname"]) . " " . trim($person["lastname"]); ?></h3>
							<p class="profile_role"><?php echo trim($person["role"]); ?></p>
							<p class="profile_role"><?php echo trim($person["background"]); ?></p>
							<?php 
								$skills = explode(",", trim($person["skills"]));
								foreach ($skills as $skill) {
									?>
										<p class="profile_role" style="color:green;display:inline-block"><?php echo trim($skill); ?></p>
									<?php
								}
							?>
						</div>
						
					</section>

					<section class="profile_details">
					
						<p class="profile_details__about"><?php echo trim($person["about"]); ?></p>	

						<p class="profile_details__email">
							<a href="mailto:<?php echo trim($person["email"]); ?>">
								<svg id="mail_ico" version="1.1" viewBox="0 0 483.3 483.3" style="enable-background:new 0 0 483.3 483.3;"><g><g><path d="M424.3,57.75H59.1c-32.6,0-59.1,26.5-59.1,59.1v249.6c0,32.6,26.5,59.1,59.1,59.1h365.1c32.6,0,59.1-26.5,59.1-59.1v-249.5C483.4,84.35,456.9,57.75,424.3,57.75z M456.4,366.45c0,17.7-14.4,32.1-32.1,32.1H59.1c-17.7,0-32.1-14.4-32.1-32.1v-249.5c0-17.7,14.4-32.1,32.1-32.1h365.1c17.7,0,32.1,14.4,32.1,32.1v249.5H456.4z"/><path d="M304.8,238.55l118.2-106c5.5-5,6-13.5,1-19.1c-5-5.5-13.5-6-19.1-1l-163,146.3l-31.8-28.4c-0.1-0.1-0.2-0.2-0.2-0.3c-0.7-0.7-1.4-1.3-2.2-1.9L78.3,112.35c-5.6-5-14.1-4.5-19.1,1.1c-5,5.6-4.5,14.1,1.1,19.1l119.6,106.9L60.8,350.95c-5.4,5.1-5.7,13.6-0.6,19.1c2.7,2.8,6.3,4.3,9.9,4.3c3.3,0,6.6-1.2,9.2-3.6l120.9-113.1l32.8,29.3c2.6,2.3,5.8,3.4,9,3.4c3.2,0,6.5-1.2,9-3.5l33.7-30.2l120.2,114.2c2.6,2.5,6,3.7,9.3,3.7c3.6,0,7.1-1.4,9.8-4.2c5.1-5.4,4.9-14-0.5-19.1L304.8,238.55z"/></g></g></svg>
								<?php echo trim($person["email"]); ?>
							</a>
						</p>

						<?php 

							// Socials array example:
							// [["facebook","https://facebook.com/user/helloworld","primary"],["twitter","https://twitter.com/user/helloworld","secondary"]]
							$socials = !empty($person["socials"]) ? json_decode(trim($person["socials"]),true) : array();
							foreach ($socials as $social) {
								?>
									<a class="profile_role <?php echo $social[2];?>" style="color:green;display:inline-block" href="<?php echo $social[1];?>"><?php echo $social[0];?></a>
								<?php
							}
	
						?>

					</section>
			        					
			        <?php

					// Check if we are looking at our profile
			        if($people_func->isMyProfile()) {
			        	echo "<div class='button button--big'><a href='../account/'>Edit Profile</a></div>";
			        }

				} else {
				    echo "Nobody is here!";
				}

			?>

			</div> <!-- end profile wrapper -->

			<?php

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
				<img src="../assets/pics/default/gridico.png" id="change_view_icon">
			</div>

			</div>

		<?php } // endif switch all users list or single user details ?>

		<?php include '../assets/php/footer.php'; ?>


		<script src="../assets/js/people.js"></script>

	</body>
</html>