<?php

	
	function ideaDiv($avatar,$id){
		if(!empty($avatar) && file_exists("../app/assets/pics/ideas/".$avatar)){
			return "<div id='idea_picture__".$id."' style=\"background-image:url('../app/assets/pics/ideas/".$avatar."')\"></div>";
		} else {
			return "<div style=\"background-image:url('../app/assets/pics/default/idea_pic.png')\"  id='idea_picture__".$id."'></div>";
		}
	}



	$ideas_html = "<h3>NOW IS TIME TO VOTE!<br>REMEMBER YOU CAN LIKE MAXIMUM 3 IDEAS</h3>";

	foreach ($ideas as $idea){

		$ideas_html .= "

		<div class='idea' id='i".$idea['id']."'>

			<div class='picture_box'>";

				$ideas_html .= ideaDiv($idea['avatar'],$idea['id']);

				$ideas_html .= "

			</div>
			<div class=\"info_box\">

				<p class='idea_title' id='idea_title__".$idea['id']."'>".$idea['title']."</p>

				<p class='idea_description' id='idea_description__".$idea['id']."'>".$idea['description'].".</p>

	        	<p class='idea_background' id='idea_background__".$idea['id']."'>Looking for: ".$idea['looking_for']."</p>"; 

			// Votes functionality -> available to students and mentors
			if ($isStudent || $isMentor){

				$ideas_html .= "<div class='info_box_footer'>";
				
					// Set the current idea
					$ideas_func->setIdea($idea['id']);
				
					// Check if user liked or not the idea yet
					$userlikes = $ideas_func->getUserLikes();
					if(!in_array($idea['id'], $userlikes)){

						$ideas_html .= "<input type='button' class='c_green' value='Like' onclick='SpIdea.ideaHelper(\"like\",\"".$idea['id']."\",this);' />";

					} else {

						$ideas_html .= "<input type='button' class='c_red' value='Unlike' onclick='SpIdea.ideaHelper(\"unlike\",\"".$idea['id']."\",this);' />";

					}

				$ideas_html .= "</div>"; // info_box_footer

			}
	    
	    $ideas_html .= "</div></div>"; // info_box & idea element

	}

	return $ideas_html;

?>