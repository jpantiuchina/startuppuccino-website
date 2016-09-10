<?php

	function ideaDiv($avatar,$id){
		if(!empty($avatar) && file_exists("../app/assets/pics/ideas/".$avatar)){
			return "<div id='idea_picture__".$id."' style=\"background-image:url('../app/assets/pics/ideas/".$avatar."')\"></div>";
		} else {
			return "<div style=\"background-image:url('../app/assets/pics/default/idea_pic.png')\"  id='idea_picture__".$id."'></div>";
		}
	}





	$ideas_html = "<h3>NOW IS TIME TO JOIN IDEAS<br>REMEBER YOU CAN JOIN ONLY ONE IDEA!</h3>";

	foreach ($ideas as $idea){
	
		// Define if the idea is approved
        $isApproved = ($idea['approved'] === 'T');

        if($isApproved){

			$ideas_html .= "

			<div class='idea' id='i".$idea['id']."'>

				<div class='picture_box'>";

					$ideas_html .= ideaDiv($idea['avatar'],$idea['id']);

					$ideas_html .= "

				</div>
				<div class=\"info_box\">

					<p class='idea_title' id='idea_title__".$idea['id']."'>".$idea['title']."</p>

					<p class='idea_description' id='idea_description__".$idea['id']."'>".$idea['description'].".</p>

		        	<p class='idea_background' id='idea_background__".$idea['id']."'>".$idea['background_pref']."</p>";

		        	
		        // Only students can join ideas (and not idea owners)
				if ($isStudent && $_SESSION['id']!=$idea['owner_id']){

				$ideas_html .= "<div class='info_box_footer'>";

					// Set the current idea
					$ideas_func->setIdea($idea['id']);
					
					// Case: User already joined this idea
	    			if($ideas_func->isMyIdea()){

						$ideas_html .= "<input type='button' class='c_green' value='Leave' onclick='SpIdea.ideaHelper(\"leave\",\"".$idea['id']."\",this)' />";
						
					// Case: User did not joined yet this idea
					} else {

	    				$ideas_html .= "<input type='button' class='c_red' value='Join' onclick='SpIdea.ideaHelper(\"join\",\"".$idea['id']."\",this)' />";

					}

				$ideas_html .= "</div>"; // info_box_footer

				}
		    
		    $ideas_html .= "</div></div>"; // info_box & idea element

		}

	}

	return $ideas_html;

?>