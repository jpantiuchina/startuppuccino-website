<?php

	// Helper function to save the result of an included script into a variable
	function includeToVar($file){
	    ob_start();
	    include($file);
	    return ob_get_clean();
	}

	function ideaDiv($avatar, $id){
		if(!empty($avatar) && file_exists("../app/assets/pics/ideas/".$avatar)){
			return "<div id='idea_picture__".$id."' style=\"background-image:url('../app/assets/pics/ideas/".$avatar."')\"></div>";
		} else {
			return "<div style=\"background-image:url('../app/assets/pics/default/idea_pic.png')\"  id='idea_picture__".$id."'></div>";
		}
	}




	$ideas_html = "";

	// Students can create new ideas
	//if ($isStudent){

		$ideas_html = "<section id='new_idea__section'>";
		$ideas_html .= includeToVar('idea_form.php');
		$ideas_html .= "</section>";
			
	//}

	// Users can comments on ideas
	if($userLogged){

		$ideas_html .= includeToVar('comment_box_view.php');

	}

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

			//if ($isStudent){

			$ideas_html .= "<div class='info_box_footer'>";

				// Edit/delete ideas -> available only for idea owener
				if($_SESSION['id']==$idea['owner_id']){

					// <input type='button' class='c_green' value='Edit' onclick='SpIdea.editIdea(\"".$idea['id']."\");'>

					$ideas_html .= "<input type='button' 
					                       class='delete_idea_button' 
					                       value='Delete' 
					                       data-idea=\"".$idea['id']."\">";

				}

				// Comments functionality -> available to all students
				$ideas_html .= "<span class='comment_idea_button' idea-id='".$idea['id']."'>Comments</span>";

			$ideas_html .= "</div>"; // info box footer

			//} // contraint only students
	    
	    $ideas_html .= "</div>"; // info_box

		$ideas_html .= "<div class='idea__footer'></div>";
	    $ideas_html .= "</div>"; // & idea element

	}

	return $ideas_html;

?>