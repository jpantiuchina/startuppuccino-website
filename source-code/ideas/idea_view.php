<?php

	require_once '../app/models/session.php';

	// Account id
	$account_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

	// Include and Initialize People Functions
	require_once '../app/models/Ideas_Functions.php';
	$ideas_func = new Ideas_Functions($account_id);


	if (!($ideas = $ideas_func->getAllIdeas())){
		return "No ideas found...";
	}

	$isStudent = $_SESSION['role']=="student";

	$ideas_html = "";

	foreach ($ideas as $idea){
	
		// Set the current idea
		$ideas_func->setIdea($idea['id']);
		// Store boolean if the user has already join the idea
		$isMyIdea = $ideas_func->isMyIdea();

		$ideas_html .= "

		<div class='list_element list_element--idea'>

			<div class='idea__details'>";

				if(!empty($idea['avatar']) && file_exists("../app/assets/pics/ideas/".$idea['avatar'])){
					$ideas_html .= "<img class='idea__details_pic' src='../app/assets/pics/ideas/".$idea['avatar']."' width='100'/>";
				}

				$ideas_html .= "

				<h3 class='idea__details_title'>".$idea['title']."</h3>

				<p class='idea__details_description'>".$idea['description'].".</p>

	        	<div class='idea__details_extra'>

	        		<span>
	        			<a href='../people/?user_id=".$idea['owner_id']."'>".$idea['firstName']." ".$idea['lastName']."</a>
	        		</span>

	        		<span>".$idea['date']."</span>

	        		<span id='team_".$idea['id']."'>Team size: ".$idea['current_team_size']."</span>";

	        		if (trim($idea['background_pref'])!=""){
		        		$ideas_html .= "<span>".$idea['background_pref']."</span>";
					}

			$ideas_html .= "</div></div>"; // idea__details_extra idea__details

			if ($isStudent){

			$ideas_html .= "<div class='idea__footer'>";
					
				// Phase 1: ideas publications and votes
				if($_SESSION['ideas_phase']==1){

					// Check if user is the owner
					if($_SESSION['id']==$idea['owner_id']){

						$ideas_html .= "<span  class='idea__button idea__button--full' onclick='editIdea(\"".$idea['id']."\");'>EDIT IDEA</span>
										<span  class='idea__button idea__button--delete' onclick='deleteIdea(\"".$idea['id']."\");'>DELETE IDEA</span>";
					
					}

					// Print out vote button
					// ...

				// Phase 2: ideas join/leave
				} else if($_SESSION['ideas_phase']==2 && $_SESSION['id']!=$idea['owner_id']){

					// Case: User already joined this idea
        			if($isMyIdea){

						$ideas_html .= "<span class='idea__button' onclick='ideaHelper(\"leave\",\"".$idea['id'];"\",this)'>LEAVE IDEA</span>";
						
    				// Case: User did not joined yet this idea
					} else {

        				$ideas_html .= "<span class='idea__button' onclick='ideaHelper(\"join\",\"".$idea['id']."\",this)'>JOIN IDEA</span>";

    				}

    			}

			$ideas_html .= "</div>"; // idea__footer

			}
	    
	    $ideas_html .= "</div>"; // list_element

	}

	return $ideas_html;

?>