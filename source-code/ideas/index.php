<?php

	require_once '../app/models/session.php';
	
	// Account id
	$account_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

	// Include and Initialize People Functions
	require_once '../app/models/Ideas_Functions.php';
	$ideas_func = new Ideas_Functions($account_id);

?>

<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../app/assets/css/form.css">
		<link rel="stylesheet" type="text/css" href="../app/assets/css/ideas.css">
		<link rel="stylesheet" type="text/css" href="../app/assets/css/general.css">
		<link rel="stylesheet" type="text/css" href="../app/assets/css/listview.css">
		<title>Ideas - Startuppuccino</title>

	</head>
	<body>
		
		<?php include '../app/views/header.php'; ?>
		
		<main>

			<?php
			
			// List all the ideas

			// If user is logged, can create new ideas 
			if ($userLogged){

				// Get the current user ideas IDs
        		$user_ideas = $ideas_func->getAllMyIdeasID();

        		// Show the form to create a new Idea
        		?>
        			<div class="new_idea__button">
        				<span onclick="showIdeaForm()">NEW IDEA</span>
        		  	</div>
        		  	<section id="new_idea__section">
        		  		<div class="new_idea__button">
        		  			<span  onclick="hideIdeaForm()">CANCEL</span>
        		  		</div>
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

					        	<div class="list_element list_element--idea">

					        		<div class="idea__details">

					        			<h3 class="idea__details_title">
					        				<?php print $idea['title']; ?>
					        			</h3>

					        			<p class="idea__details_description">
						        			<?php print $idea['description']; ?>
						        		</p>

							        	<div class="idea__details_extra">

							        		<span>
							        			<a href="../people/?user_id=<?php print $idea['owner_id']; ?>"><?php print $idea['firstName']." ".$idea['lastName']; ?></a>
							        		</span>

							        		<span>
							        			<?php print $idea['date']; ?>
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

					        			<div class="idea__footer">
					        				
					        				<?php // Case: Idea owner ?>
					        				<?php if($_SESSION['id'] == $idea['owner_id']){ ?>
	
						        				<?php // Filter to highlight user ideas or joined ideas ?>
					        					<!-- <div class="idea__lens"></div> -->

					        					<!--<span  class="idea__button idea__button--full" onclick="editIdea('<?php print $idea['id']; ?>');">EDIT IDEA</span> -->
					        					<span  class="idea__button idea__button--delete" onclick="deleteIdea('<?php print $idea['id']; ?>');">DELETE IDEA</span>
					        					
					        				<?php } else { ?>

					        					<?php // Case: User not join this idea ?>
					        					<?php if(!$isMyIdea && !$teamCompleted){ ?>

						        					<span class="idea__button" onclick="ideaHelper('join','<?php print $idea['id']; ?>',this)">JOIN IDEA</span>

						        				<?php // Case: User not join this idea ?>
							        			<?php } else if($isMyIdea){ ?>

						        					<?php // Filter to highlight user ideas or joined ideas ?>
					        						<!-- <div class="idea__lens"></div> -->
							        				
							        				<span class="idea__button" onclick="ideaHelper('leave','<?php print $idea['id']; ?>',this)">LEAVE IDEA</span>

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

		<?php include '../app/views/footer.php'; ?>

		<script src="../app/assets/js/ideas.js"></script>

	</body>
</html>