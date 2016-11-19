/* Ideas class */
function StartuppuccinoProjectChooser(){

	/* JOIN & LEAVE / LIKE & UNLIKE */

	var BUTTON_SELECTED,
	    PROJECT_ID,
	    CONTROLLER_DIR = "../app/controllers/",
	    PROJECT_MANAGE_CONTROLLER = CONTROLLER_DIR + "manage_startups_project.php";
	    IDEA_MANAGE_CONTROLLER = CONTROLLER_DIR + "manage_ideas.php";

	this.ideaHelper = function(action, project_id, dom_element){
		
		// show the loading
		Sp.layout.showLoading();

		// save temporary the button and idea selected
		BUTTON_SELECTED = dom_element;
		PROJECT_ID = project_id;

		// send data to server
		var data = {
			url : PROJECT_MANAGE_CONTROLLER,
			parameters : "key=" + action + "_project&project_id=" + project_id
		}

		Sp.post(data, function(response){

				if(response == "ok"){

					if (action == "like"){

						// Change style to the button
						BUTTON_SELECTED.value = "Un-choose";
						BUTTON_SELECTED.className = "c_red st_button";
						BUTTON_SELECTED.style = "background-color: #f00";
						
						// Update click listener from the button
						BUTTON_SELECTED.setAttribute("onclick", "SpProjectChooser.ideaHelper('unlike','" + PROJECT_ID + "',this);");
				
					} else if (action == "unlike"){

						// Change style to the button
						BUTTON_SELECTED.value = "Choose";
						BUTTON_SELECTED.className = "c_green st_button";
						BUTTON_SELECTED.style = "";
						
						// Update click listener from the button
						BUTTON_SELECTED.setAttribute("onclick", "SpProjectChooser.ideaHelper('like','" + PROJECT_ID + "',this);");
				
					} else {

						alert("Error js: action not set. "+action);

					}

				} else {

					alert(response);

				}

				// hide loading screen
				Sp.layout.hideLoading();

				// Reset variable button_selected;
				BUTTON_SELECTED = null;

			});

	}

}


/* Ideas class */
function StartuppuccinoIdeas(){

	/* COMMENTS */
	
	var COMMENT_BOX_IDEAID = null;

	this.submitComment = function(){

		Sp.layout.showLoading();

		var comment = document.getElementById("comment_textarea").value;
		if(comment==""){
			alert("Your comment is empty");
			Sp.layout.hideLoading();
			return false;
		}

		Sp.post({
				url : IDEA_MANAGE_CONTROLLER,
				parameters : "key=new_comment&idea_id=" + COMMENT_BOX_IDEAID + "&comment=" + comment
			},function(response){
				if(response == "ok"){
					//alert("Comment correctly published");
					// Refresh comments
					SpIdea.loadComments();
					// Empty textarea
					document.getElementById("comment_textarea").innerHTML = "";
					document.getElementById("comment_textarea").value = "";
				} else {
					alert(response);
				}
				// Hide loader
				Sp.layout.hideLoading();
			});

		return false;
	}

	this.deleteComment = function(e){

		var button = e.target || e.srcElement,
			idea_id = button.getAttribute("data-idea"),
			comment_id = button.parentNode.parentNode.getAttribute("comment-id"),
			comment_text = button.parentNode.parentNode.childNodes[3].innerHTML;

		if( !confirm("Do you really want to delete the comment?") ){
			return;
		}

		var data = {};

		// Show loader -> try to prevent double click on button
		Sp.layout.showLoading();

		data.url = IDEA_MANAGE_CONTROLLER;
		data.parameters = "idea_id=" + idea_id +
			"&comment_id=" + comment_id +
			"&key=delete_comment";

		Sp.post(
			data,
			function(response){
				if(response == "ok") {
					SpIdea.loadComments();
				} else {
					alert(response);
				}
				// Hide loader
				Sp.layout.hideLoading();
			});

	}

	this.loadComments = function(){

		// Load comments of selected idea
		Sp.post({
				url : IDEA_MANAGE_CONTROLLER,
				parameters : "key=get_comments&idea_id=" + COMMENT_BOX_IDEAID
			}, function(comments){
				// Load comments in the comments box
				document.getElementById("comments").innerHTML = comments;

				// Add event listerner to delete comments
				var comment_delete_buttons = document.getElementsByClassName("comment__delete"),
		            comment_delete_buttons_length = comment_delete_buttons.length;
				for (var i = 0; i < comment_delete_buttons_length; i++) {
					comment_delete_buttons[i].addEventListener("click", function(e){ SpIdea.deleteComment(e); });
				}
		});
	}

	this.hideCommentBox = function(){
		
		var comment_box = document.getElementsByClassName("comment_box")[0];
		comment_box.className = "comment_box";

		COMMENT_BOX_IDEAID = null;
		
		// Empty comment box
		document.getElementById("comments").innerHTML = "Loading comments...";
	}

	this.showCommentBox = function(e){
		
		var button = e.target || e.srcElement,
	        idea_id = button.getAttribute("idea-id"),
		    comment_box = document.getElementsByClassName("comment_box")[0];
		
		comment_box.className = "comment_box comment_box--visible";
		COMMENT_BOX_IDEAID = idea_id;
		
		this.loadComments();

	}



}


/* Initialize Startuppuccino Project Chooser */

if(typeof SpProjectChooser === "undefined" || SpProjectChooser === null){

	var SpProjectChooser = new StartuppuccinoProjectChooser();

}
/* Initialize Startuppuccino Idea -- temp: only for comments */

if(typeof SpIdea === "undefined" || SpIdea === null){

	var SpIdea = new StartuppuccinoIdeas();

}

/* Add event listeners */

window.addEventListener("load", function(){

	var comment_idea_buttons = document.getElementsByClassName("comment_idea_button");

	var comment_idea_buttons_length = comment_idea_buttons.length;
	
	for (var i = 0; i < comment_idea_buttons_length; i++) {
		comment_idea_buttons[i].addEventListener("click", function(e){ SpIdea.showCommentBox(e); });
	}

});