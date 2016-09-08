<?php

	$ideas_html = "";

	foreach ($ideas as $idea){

		$ideas_html .= "

		<div class='list_element list_element--idea' id='i".$idea['id']."'>

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
		    
		        </div>
			
			</div>

		</div>"; // list_element

	}

	return $ideas_html;

?>