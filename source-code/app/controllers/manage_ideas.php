<?php
	
	require_once '../models/session.php';

	function cleanText($text){
		return str_replace("'", " ", $text);
	}

	if(!isset($_POST['key']) || empty($_POST['key'])){
		// No parameter key is set so nothing happens
		exit("...");
	} else {
		$key = $_POST['key'];
	}

	// Include and Initialize People Functions
	require_once '../models/Ideas_Functions.php';
	$account_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
	$ideas_func = new Ideas_Functions($account_id);

	// Set the current idea
	$idea_id = isset($_POST['idea_id']) ? $_POST['idea_id'] : null;
	$ideas_func->setIdea($idea_id);

	// TODO: add check for current user role

	// Check current ideas phase
	$phase1 = ["new_idea","delete_idea","edit_idea","get_comments","new_comment","delete_comment"];
	$phase2 = ["like_idea","unlike_idea","new_comment","get_comments","delete_comment"];
	$phase3 = ["join_idea","leave_idea"];
	if(($_SESSION['ideas_phase']==1 && !in_array($key, $phase1)) ||
	   ($_SESSION['ideas_phase']==2 && !in_array($key, $phase2)) ||
	   ($_SESSION['ideas_phase']==3 && !in_array($key, $phase3))){
		exit("Error, you do not have the access to this functionality.");
	}

	switch ($key) {

		case 'join_idea':

			exit($ideas_func->joinIdea());
			
		case 'leave_idea':
		
			exit($ideas_func->leaveIdea());
		
		case 'new_idea':

			exit($response = $ideas_func->newIdea(cleanText($_POST['title']),
											//$_POST['team_size'],
											cleanText($_POST['description']),
											$_POST['avatar'],
											cleanText($_POST['background_pref'])));
			
		case 'teamsize':
		
			exit($ideas_func->getTeamsize());
		
		case 'delete_idea':
			
			exit($ideas_func->deleteIdea());

		case 'edit_idea':

			//exit("Not yet implemented");
			exit($ideas_func->editIdea($_POST['title'],
										//$_POST['team_size'],
										$_POST['description'],
										$_POST['avatar'],
										$_POST['background_pref']));

		case 'get_comments':

			$comments_string = "";
			foreach ($ideas_func->getComments() as $comment) {

				// Set avatar
				$author_avatar = !empty($comment['author_avatar']) ? $comment['author_avatar'] : "avatar.svg";

				$comments_string .= '<div class="comment" comment-id="'.$comment['id'].'">
										<a class="comment__author" 
				                        	href="../people/?user_id='.$comment['author_id'].'">
				                        	<div style="background-image:url(\'../app/assets/pics/people/'.$author_avatar.'\');background-color:#fbfbfb"></div>
				                    	</a>
				                    	<p class="comment__text">
				                    	<a href="../people/?user_id='.$comment['author_id'].'">
				                        	<b>'.$comment['author_firstname'].' '.$comment['author_lastname'].' </b></a>
				                        '.$comment['text'].'</p>';

				// Check if is the owner of the comment
				if($_SESSION['id'] === $comment['author_id']){
					$comments_string .= '<div class="comment__footer">
											<span class="comment__delete" data-idea="'.$comment['project_id'].'">delete</span>
										</div>';
				}

				$comments_string .= '</div>';
			}

			exit($comments_string);

		case 'new_comment':

			exit($ideas_func->newComment(cleanText($_POST['comment'])));

		case 'delete_comment':

			exit($ideas_func->deleteComment($_POST['comment_id']));

		case 'like_idea':

			exit($ideas_func->like());

		case 'unlike_idea':

			exit($ideas_func->unlike());

	}

?>