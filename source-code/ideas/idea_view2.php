<?php

	$ideas_html = "<h3>NOW IS TIME TO VOTE!<br>REMEMBER YOU CAN LIKE MAXIMUM 3 IDEAS</h3>";

	$ideas_html .= "<h4 style='background-color:#000;color:#fff;cursor:pointer' onclick='showAskForHelp()'>ASK FOR HELP</h4>";

	foreach ($ideas as $idea){

		$ideas_html .= "

		<div class='list_element list_element--idea'>

			<div class='idea__details'>";

				if(!empty($idea['avatar']) && file_exists("../app/assets/pics/ideas/".$idea['avatar'])){
					$ideas_html .= "<img class='idea__details_pic'  id='idea_picture__".$idea['id']."' src='../app/assets/pics/ideas/".$idea['avatar']."' width='100'/>";
				} else {
					$ideas_html .= "<img style='display:none' src=''  id='idea_picture__".$idea['id']."'/>";
				}

				$ideas_html .= "

				<h3 class='idea__details_title' id='idea_title__".$idea['id']."'>".$idea['title']."</h3>

				<p class='idea__details_description' id='idea_description__".$idea['id']."'>".$idea['description'].".</p>

	        	<div class='idea__details_extra'>

	        		<span>".$idea['date']."</span>

					<span  id='idea_background__".$idea['id']."'>".$idea['background_pref']."</span>

				</div>
			
			</div>"; // idea__details_extra idea__details

			// Votes functionality -> available to students and mentors
			if ($isStudent || $isMentor){

				$ideas_html .= "<div class='idea__footer'>";
				
					// Set the current idea
					$ideas_func->setIdea($idea['id']);
				
					// Check if user liked or not the idea yet
					$userlikes = $ideas_func->getUserLikes();
					if(!in_array($idea['id'], $userlikes)){

						$ideas_html .= "<span  class='idea__button idea__button--full' onclick='ideaHelper(\"like\",\"".$idea['id']."\",this);'>LIKE</span>";

					} else {

						$ideas_html .= "<span  class='idea__button idea__button--full' onclick='ideaHelper(\"unlike\",\"".$idea['id']."\",this);'>UNLIKE</span>";

					}

				$ideas_html .= "</div>"; // idea__footer

			}
	    
	    $ideas_html .= "</div>"; // list_element

	}

	return $ideas_html;

?>