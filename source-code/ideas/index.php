<?php

	require '../assets/php/session.php';

	require '../assets/php/db_connect.php';

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
				 /* If isset the get parameter 'idea_id' ( ../index.php?idea_id=xxxx )
				 links like ../ideas/xxxx are manage with .htaccess and loaded the content as the sintax above ( with GET parameter )
				 then the idea details are diplayed instead of the list of ideas */
			?>

			<?php if (isset($_GET['idea_id'])){ ?>

				<!-- Project details -->

				<?php

					$ideaID = $_GET['idea_id'];

					require 'idea.php';

				?>

			<?php } else {

				// Ideas list

				$ideas = mysqli_query($dbconn, "SELECT i.title,
															 i.description,
															 i.team_size,
															 i.current_team_size,
															 i.date,
															 i.background_pref,
															 a.firstName, 
															 a.lastName,
															 i.id,
															 i.owner_id
													  FROM Ideas i, Account a WHERE i.owner_id = a.id");

				if ($userLogged){

					// Get the current user ideas ids
	        		$user_ideas = [];
	        		$user_ideas_x = mysqli_query($dbconn,"SELECT idea_id FROM IdeaAccount WHERE account_id='".$_SESSION['id']."';");
	        		while($i = mysqli_fetch_assoc($user_ideas_x)){
	        			$user_ideas[] = $i['idea_id'];
	        		}

	        		// Show the form to create a new Idea
	        		?>
	        			<span id="new_idea__button" class="button" onclick="document.getElementById('new_idea__section').style.display='block'">
	        				NEW IDEA
	        		  	</span>
	        		  	<section id="new_idea__section">
	        		  		<div class="close close--topright" onclick="this.parentNode.style.display='none'"></div>
	        		  		<?php include 'idea_form.php'; ?>
	        		  	</section>
	        		<?php

	        	} ?>

				<section class="list_view">

					<?php

						if (mysqli_num_rows($ideas) > 0){

							foreach ($ideas as $idea){
							
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

						        					<span  class="card__button card__button--full" onclick="editIdea('<?php print $idea['id']; ?>');">EDIT IDEA</span>
						        					<span  class="card__button card__button--full" onclick="deleteIdea('<?php print $idea['id']; ?>');">DELETE IDEA</span>

						        				<?php // Case: User not join this idea ?>
						        				<?php // FIX THIS!!!!! WRONG IF ELSE CONDITION ?>
						        				<?php } else { ?>

						        					<?php if(!in_array($idea['id'],$user_ideas) && !$teamCompleted){ ?>

							        					<span class="card__button card__button--full" onclick="ideaHelper('join','<?php print $idea['id']; ?>',this)">JOIN IDEA</span>

							        				<?php // Case: User not join this idea ?>
								        			<?php } else if(in_array($idea['id'],$user_ideas)){ ?>
								        				
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

						mysqli_close($dbconn);

					?>

				</section>

			<?php } // endif switch all users list or single user details ?>

		</main>

		<?php include '../assets/php/footer.php'; ?>

		<script src="../assets/js/ideas.js"></script>

	</body>
</html>