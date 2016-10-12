<?php

	function ideaDiv($avatar,$id){
		if(!empty($avatar) && file_exists("../app/assets/pics/ideas/".$avatar)){
			return "<div id='idea_picture__".$id."' style=\"background-image:url('../app/assets/pics/ideas/".$avatar."')\"></div>";
		} else {
			return "<div style=\"background-image:url('../app/assets/pics/default/idea_pic.png')\"  id='idea_picture__".$id."'></div>";
		}
	}

	

	$ideas_html = "";

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
			
			</div>

		</div>"; // idea element

	}

	return $ideas_html;

?>