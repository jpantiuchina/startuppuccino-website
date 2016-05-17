<?php

	// TODO: improve the script in order to automatically fix not executed queries and database errors

	require_once '../../../assets/php/session.php';

	// Check if the current user is an "educator"
	if($_SESSION['role'] == "educator"){

		if(isset($_POST['idea_id'])){

			$idea_id = $_POST['idea_id'];

			// connect db
			require '../../../assets/php/db_connect.php';

			if($idea_data = mysqli_query($dbconn,"SELECT * FROM Ideas WHERE id='".$idea_id."';")){

				// Fetch idea data into an array
				$idea_data = mysqli_fetch_assoc($idea_data);
				
				// Get idea members
				if($idea_members_result = mysqli_query($dbconn,"SELECT account_id FROM IdeaAccount WHERE idea_id='".$idea_id."';")){

					// Fetch idea members into array
					$idea_members = [];
					while($member = mysqli_fetch_assoc($idea_members_result)){
						$idea_members[] = $member['account_id'];
					}
					// Add the idea owner to the idea members (not included in the IdeaAccount table)
					$idea_members[] = $idea_data['owner_id'];
					
					// Add new Team
					// When the team is created it will have the same name of their idea title
					$query = "INSERT INTO Teams (name) VALUES ('".$idea_data['title']."');";
					
					if(mysqli_query($dbconn,$query)){

						$team_id = mysqli_insert_id($dbconn);
						
						// Add new team members
						$member_not_added = [];
						foreach ($idea_members as $member_id) {
							
							if(!mysqli_query($dbconn,"INSERT INTO TeamAccount (team_id,date,account_id) VALUES ('".$team_id."',NOW(),'".$member_id."')")){

								$member_not_added[] = $member_id;

							}
						}

						if(count($member_not_added)==0){

							// Create the project associated with the team
							$query = "INSERT INTO Project (description,title,team_id,created_date,updated_date) VALUES ('".$idea_data['description']."','".$idea_data['title']."','".$team_id."',NOW(),NOW())";

							if(mysqli_query($dbconn,$query)){

								// Delete the idea tuples from Ideas and IdeaAccount
								$query = "DELETE FROM Ideas WHERE id='".$idea_id."';";
								$query .= "DELETE FROM IdeaAccount WHERE idea_id='".$idea_id."';";

								if(mysqli_multi_query($dbconn,$query)){

									echo "Idea has been converted into the new team '".$idea_data['title']."'";

								} else {

									die("The new team has been created but it was not possible to delete the idea. ".mysqli_error($dbconn));

								}

							} else {

								die("I'm sorry, I could not create the new project. ".mysqli_error($dbconn));

							}

						} else {

							die("I'm sorry, finally I could not store ".count($member_not_added)." team members");

						}

					} else {

						die("I'm sorry, I was not able to create a new team. ".mysqli_error($dbconn));

					}

				} else {

					die("I'm sorry, I was not able to get the idea members. ".mysqli_error($dbconn));

				}

			} else {

				die("I'm sorry, I was not able to get the idea data. ".mysqli_error($dbconn));

			}


		} else {

			die("No idea selected");

		}

	} else {

		die("You cannot do this!");

	}


?>