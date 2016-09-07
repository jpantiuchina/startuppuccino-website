<?php

	$ideas_html = "<h3>NOW IS TIME TO JOIN IDEAS<br>REMEBER YOU CAN JOIN ONLY ONE IDEA!</h3>";

	$ideas_html .= "<h4 style='background-color:#000;color:#fff;cursor:pointer' onclick='showAskForHelp()'>ASK FOR HELP</h4>";

	foreach ($ideas as $idea){
	
		// Define if the idea is approved
        $isApproved = ($idea['approved'] === 'T');

        if($isApproved){

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

		        		<span>
		        			<a href='../people/?user_id=".$idea['owner_id']."'>".$idea['firstName']." ".$idea['lastName']."</a>
		        		</span>

		        		<span>".$idea['date']."</span>

		        		<span  id='idea_background__".$idea['id']."'>".$idea['background_pref']."</span>

		        	</div>

		        	<div class='idea__details_extra'>";

		        		// Print ideas members

		        	$ideas_html .= "
					</div>

		        </div>"; // idea__details_extra idea__details

		        // Only students can join ideas (and not idea owners)
				if ($isStudent && $_SESSION['id']!=$idea['owner_id']){

				$ideas_html .= "<div class='idea__footer'>";

					// Set the current idea
					$ideas_func->setIdea($idea['id']);
					
					// Case: User already joined this idea
	    			if($ideas_func->isMyIdea()){

						$ideas_html .= "<span class='idea__button' onclick='SpIdea.ideaHelper(\"leave\",\"".$idea['id']."\",this)'>LEAVE IDEA</span>";
						
					// Case: User did not joined yet this idea
					} else {

	    				$ideas_html .= "<span class='idea__button' onclick='SpIdea.ideaHelper(\"join\",\"".$idea['id']."\",this)'>JOIN IDEA</span>";

					}

				$ideas_html .= "</div>"; // idea__footer

				}
		    
		    $ideas_html .= "</div>"; // list_element

		}

	}

	return $ideas_html;

?>