<?php

	// Helper function to save the result of an included script into a variable
	function includeToVar($file){
	    ob_start();
	    include($file);
	    return ob_get_clean();
	}

	$ideas_html = "";

	// Students can create new ideas
	if ($isStudent){

		$ideas_html = "
			<div class='new_idea__button'>
				<span onclick='openNewIdeaForm()'>NEW IDEA</span>
		  	</div>
		  	<section id='new_idea__section' style='position: relative;top: -50px;margin-top:0px'>
		  		<div class='new_idea__button'>
		  			<span  onclick='hideIdeaForm()'>CANCEL</span>
		  		</div>";
		$ideas_html .= includeToVar('idea_form.php');
		$ideas_html .= "</section>";
			
	}

	// Users can comments on ideas
	if($userLogged){

		//$ideas_html .= includeToVar('comment_box_view.php');

	}

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

			if ($isStudent){

			$ideas_html .= "<div class='idea__footer'>";

				// Edit/delete ideas -> available only for idea owener
				if($_SESSION['id']==$idea['owner_id']){

					$ideas_html .= "<span  class='idea__button idea__button--full' onclick='editIdea(\"".$idea['id']."\");'>EDIT IDEA</span>
									<span  class='idea__button idea__button--delete' onclick='deleteIdea(\"".$idea['id']."\");'>DELETE IDEA</span>";
				
				}

				// Comments functionality -> available to all students
				//$ideas_html .= "<br><span class='idea__button idea__button--full' onclick='displayComments(".$idea['id'].")'>COMMENTS</span>";

			$ideas_html .= "</div>"; // idea__footer

			}
	    
	    $ideas_html .= "</div>"; // list_element

	}

	return $ideas_html;

?>