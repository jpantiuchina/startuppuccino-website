<?php

	include '../assets/php/session.php';

	include '../assets/php/db_connect.php';

?>

<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../assets/css/form.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/people.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/general.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/listview.css">
		<title>Ideas - Startuppuccino</title>

	</head>
	<body>
		
		<?php include '../assets/php/header.php'; ?>
		
		<?php
			 /* If isset the get parameter 'idea_id' ( ../index.php?idea_id=xxxx )
			 links like ../ideas/xxxx are manage with .htaccess and loaded the content as the sintax above ( with GET parameter )
			 then the idea details are diplayed instead of the list of ideas */
		?>

		<?php if (isset($_GET['idea_id'])){ ?>

			<!-- Project details -->

			<?php

				$ideaID = $_GET['idea_id'];

				include 'idea.php';

			?>

		<?php } else { ?>

			<!-- Ideas list -->

			<?php $ideas = mysqli_query($dbconn, "SELECT i.title,
														 i.description,
														 i.team_size,
														 i.date,
														 i.background_pref,
														 a.firstName, 
														 a.lastName
												  FROM Ideas i, Account a WHERE i.owner_id = a.id"); ?>

			<br><br>

			<section class="list_view">

				<?php

					if (mysqli_num_rows($ideas) > 0){

						foreach ($ideas as $idea){
						
					        ?>

					        	<div class="card">

					        		<div class="card__details card__details--idea">
					        			<a>
						        			<span class="card__details_name">
							        			<?php print $idea['title']; ?>
							        		</span>
							        		<span class="card__details_description">
							        			<?php print $idea['description']; ?>
							        		</span>
							        		<span>
							        			<?php print $idea['firstName']." ".$idea['lastName']; ?>
							        		</span>
							        		<span>
							        			<?php print $idea['team_size']; ?>
							        		</span>
							        		<span>
							        			<?php print $idea['date']; ?>
							        		</span>
							        		<span>
							        			<?php print $idea['background_pref']; ?>
							        		</span>
						        		</a>
						        	</div>

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

		<?php include '../assets/php/footer.php'; ?>

	</body>
</html>