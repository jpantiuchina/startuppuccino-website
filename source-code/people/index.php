<?php

	require_once '../app/models/session.php';

	// Redirect to home if user is not logged
	if(!$userLogged){
		header("Location: ../");
		exit;
	}

		<link rel="stylesheet" type="text/css" href="../app/assets/newcss/people.css">
		<title>People - Startuppuccino</title>


		<?php
			
			/* If isset the get parameter 'user_id' ( ../index.php?user_id=xxxx )
			then the user details are diplayed instead of the list of users and mentors */

		if (isset($_GET['user_id'])){

			// User profile details

			// Set the account_id of the person to show
			$people_func->setPerson($_GET['user_id']);

			if ($user = $people_func->getPersonInfo()){

				// Profile view
				include '../app/views/profile.php';	

			} else {

				echo "Nobody is here";

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
							        			
							        			$pic_name = "../app/assets/pics/people/".$person['avatar'];

							        			if(!empty(trim($person['avatar'])) && file_exists($pic_name)){
								        			// set the user picture
								        			echo 'style="background-image:url(\'' . $pic_name . '\')"';
							        			} else {
							        				// set the default picture
								        			echo 'style="background-image:url(\'../app/assets/pics/default/people.png\');/*background-size:190px 190px;*/opacity:0.4"';
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
				<img src="../app/assets/pics/default/gridico.png" id="change_view_icon">
			</div>

			</div>

		<?php } // endif switch all users list or single user details ?>


		</main>


		<?php include '../app/views/footer.php'; ?>


		<script src="../app/assets/js/people.js"></script>



<?php

	require_once '../app/models/session.php';

	// Redirect to home if user is not logged
	if(!$userLogged){
		header("Location: ../");
		exit;
	}

	// Account id
	$account_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
	$isStudent = (isset($_SESSION['role']) && $_SESSION['role']=="student");
	$isMentor = (isset($_SESSION['role']) && $_SESSION['role']=="mentor");

	// Include and Initialize People Functions
	require_once '../app/models/People_Functions.php';
	$people_func = new People_Functions($_SESSION['id']);

	$ideas = [];

	$currentPage = "ideas";
	$page_title = "Ideas - Startuppuccino";
	$metatags = [
					[
						"kind" => "link",
						"type" => "text/css",
						"rel"  => "stylesheet",
						"href" => "../app/assets/newcss/ideas.css"
					]
				];
	$footer_scripts = ["../app/assets/js/ideas.js"];
	$view = null;
	$user_can_join = count($ideas_func->user_joins) < 1;


	if ( !($ideas = $ideas_func->getAllIdeas()) && $_SESSION['ideas_phase'] != "1" ){
		
		// Do nothing ... ideas is empty array

	} else {

		shuffle($ideas);
		// Include the view switch to include the right block according to idea phase
		include '../app/controllers/ideas__view_switch.php';

	}


	// Include header and footer controllers
	include '../app/controllers/page__header.php';
	//include '../app/controllers/page__footer.php';

	// Set template name and variables
	
	$template_file = "ideas.twig";

	$template_variables['sess'] = $_SESSION;
	$template_variables['userLogged'] = $userLogged;
	$template_variables['page_title'] = $page_title;
	$template_variables['metatags'] = $metatags;
	$template_variables['footer_scripts'] = $footer_scripts;
	$template_variables['rel_path'] = '..';
	$template_variables['user_can_join'] = $user_can_join;
	if($_SESSION['ideas_phase'] == "3"){
		$template_variables['joined_idea'] = $ideas_func->getJoinedIdea();
	}

    // Render the template
    require_once '../app/views/_Twig_Loader.php';
    echo (new Twig_Loader())->render($template_file, $template_variables);


?>