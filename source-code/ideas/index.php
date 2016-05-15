<?php

	require '../assets/php/session.php';
	
	// Include and Initialize People Functions
	require_once '../assets/php/Ideas_Functions.php';
	$ideas_func = new Ideas_Functions($_SESSION['id']);

?>

<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../assets/css/form.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/ideas.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/general.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/listview.css">
		<title>Ideas - Startuppuccino</title>

	</head>
	<body>
		
		<?php include '../assets/php/header.php'; ?>
		
		<main>

			<?php
			
			// List all the ideas

			// If user is logged, can create new ideas 
			if ($userLogged){

				// Get the current user ideas IDs
        		$user_ideas = $ideas_func->getAllMyIdeasID();

        		// Show the form to create a new Idea
        		?>
        			<span id="new_idea__button" class="button" onclick="showIdeaForm()">
        				NEW IDEA
        		  	</span>
        		  	<section id="new_idea__section">
        		  		<div class="close close--topright" onclick="hideIdeaForm()"></div>
        		  		<?php include 'idea_form.php'; ?>
        		  	</section>
        		<?php

        	} ?>

			<section class="list_view">

				<?php

					if ($ideas = $ideas_func->getAllIdeas()){

						foreach ($ideas as $idea){
						
							// Set the current idea
							$ideas_func->setIdea($idea['id']);
							// Store boolean if the user has already join the idea
							$isMyIdea = $ideas_func->isMyIdea();

					        ?>

					        	<div class="card card--idea">

					        		<div class="card__details">

					        			<h5 class="card__details_title">
					        				<?php print $idea['title']; ?>
					        			</h5>

					        			<p class="card__details_description">
						        			<?php print $idea['description']; ?>
						        		</p>

							        	<div class="card__details_extra">

							        		<span>
							        			Owner: <?php print $idea['firstName']." ".$idea['lastName']; ?>
												- <?php print $idea['date']; ?>
							        		</span>

							        		<span id="team_<?php print $idea['id'];?>" maxteamsize="<?php print $idea['team_size'];?>">
							        			Team size: <?php print $idea['current_team_size']."/".$idea['team_size']; ?>
							        		</span>

							        		<?php if (trim($idea['background_pref'])!=""){ ?>
								        		<span>
								        			<?php print $idea['background_pref']; ?>
								        		</span>
					        				<?php } ?>

							        		<?php if (intval($idea['current_team_size']) < intval($idea['team_size'])){ ?>

								        		<?php $teamCompleted = false; ?>

							        		<?php } else { ?>

							        			<span>
							        				Team Completed. Ready to rock!
							        			</span>

							        			<?php $teamCompleted = true; ?>

							        		<?php } ?>
							        	
						        		</div>

						        	</div>

					        		<?php if ($userLogged){ ?>

					        			<div class="card__footer center">
					        				
					        				<?php // Case: Idea owner ?>
					        				<?php if($_SESSION['id'] == $idea['owner_id']){ ?>

					        					<!--<span  class="card__button card__button--full" onclick="editIdea('<?php print $idea['id']; ?>');">EDIT IDEA</span> -->
					        					<span  class="card__button card__button--full" onclick="deleteIdea('<?php print $idea['id']; ?>');">DELETE IDEA</span>

					        				<?php } else { ?>

					        					<?php // Case: User not join this idea ?>
					        					<?php if(!$isMyIdea && !$teamCompleted){ ?>

						        					<span class="card__button card__button--full" onclick="ideaHelper('join','<?php print $idea['id']; ?>',this)">JOIN IDEA</span>

						        				<?php // Case: User not join this idea ?>
							        			<?php } else if($isMyIdea){ ?>
							        				
							        				<span class="card__button card__button--full" onclick="ideaHelper('leave','<?php print $idea['id']; ?>',this)">LEAVE IDEA</span>

						        			<?php } } ?>

					        			</div>

					        		<?php } ?>
						        
					        	</div>

					        <?php

					    }

					} else {
					    echo "Nothing to list here!";
					}

				?>

			</section>

		</main>

		<?php include '../assets/php/footer.php'; ?>

		<script src="../assets/js/ideas.js"></script>

	</body>
</html>