
/* Ideas class */
function StartuppuccinoIdeas(){

	/* JOIN & LEAVE / LIKE & UNLIKE */

	var BUTTON_SELECTED,
	    IDEA_ID,
	    TEAMSIZE_NODE,
	    CONTROLLER_DIR = "../app/controllers/",
	    IDEA_MANAGE_CONTROLLER = CONTROLLER_DIR + "manage_ideas.php";

	this.ideaHelper = function(action, idea_id, dom_element){
		
		// show the loading
		Sp.layout.showLoading();

		// save temporary the button and idea selected
		BUTTON_SELECTED = dom_element;
		IDEA_ID = idea_id;
		TEAMSIZE_NODE = document.getElementById("team_" + idea_id);

		// send data to server
		var data = {
			url : IDEA_MANAGE_CONTROLLER,
			parameters : "key=" + action + "_idea&idea_id=" + idea_id
		}

		Sp.post(data, function(response){

				if(response == "ok"){

					if(action == "join"){

						// Change style to the button
						BUTTON_SELECTED.value = "Leave";
						BUTTON_SELECTED.className = "c_red";

						// Update click listener from the button
						BUTTON_SELECTED.setAttribute("onclick", "SpIdea.ideaHelper('leave','" + IDEA_ID + "',this);");

					} else if (action == "leave"){

						// Change style to the button
						BUTTON_SELECTED.value = "Join";
						BUTTON_SELECTED.className = "c_green";
						
						// Update click listener from the button
						BUTTON_SELECTED.setAttribute("onclick", "SpIdea.ideaHelper('join','" + IDEA_ID + "',this);");
				
					} else if (action == "like"){

						// Change style to the button
						BUTTON_SELECTED.value = "Unlike";
						BUTTON_SELECTED.className = "c_red";
						
						// Update click listener from the button
						BUTTON_SELECTED.setAttribute("onclick", "SpIdea.ideaHelper('unlike','" + IDEA_ID + "',this);");
				
					} else if (action == "unlike"){

						// Change style to the button
						BUTTON_SELECTED.value = "Like";
						BUTTON_SELECTED.className = "c_green";
						
						// Update click listener from the button
						BUTTON_SELECTED.setAttribute("onclick", "SpIdea.ideaHelper('like','" + IDEA_ID + "',this);");
				
					} else {

						alert("Error js: action not set. "+action);

					}

					if(action !="like" && action != "unlike"){
						// Async update team size
						Sp.post({
								url : IDEA_MANAGE_CONTROLLER,
								parameters : "key=teamsize&idea_id=" + IDEA_ID
							},function(response){
								TEAMSIZE_NODE.innerHTML = "Team size: " + parseInt(response); // +1 is the idea owner
							});
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

	/* DELETE */

	this.deleteIdea = function(e) {

		var button = e.target || e.srcElement,
		    idea_id = button.getAttribute("data-idea"),
		    confirmMessage = "!!! Attention !!!\nAre you sure you want to delete this idea?";

		if (confirm(confirmMessage)){
			
			Sp.post({
					url : IDEA_MANAGE_CONTROLLER,
					parameters : "key=delete_idea&idea_id=" + idea_id
				},function(response){
					if(response == "ok") {
						alert("Your idea has been deleted");
						location.reload();
					} else {
						alert(response);
					}
				});
		
		}

	}

	/* EDIT */

	this.editIdea = function(idea_id) {
		// ... still to  implement
		console.log("Still to implement");

		return false;

		// Set parameters
		document.getElementById("idea_form_title").setAttribute("value",document.getElementById("idea_title__"+idea_id).innerHTML);
		document.getElementById("idea_form_description").innerHTML = document.getElementById("idea_description__"+idea_id).innerHTML;
		document.getElementById("idea_form_avatar").setAttribute("value",document.getElementById("idea_picture__"+idea_id).src);
		document.getElementById("idea_form_background_pref").setAttribute("value",document.getElementById("idea_background__"+idea_id).innerHTML);
		document.getElementById("target_picture").setAttribute("src",document.getElementById("idea_picture__"+idea_id).src);
		//document.getElementById("idea_form").setAttribute("onsubmit","return SpIdea.publishIdea(false,'"+idea_id+"');");

		// Open idea form
		this.showIdeaForm();
		
	}

	var editCallback = function(response){
		if(response == "ok") {
			alert("Your idea has been updated");
			location.reload();
		} else {
			alert(response);
		}
	};

	/* PUBLISH */

	this.uploadIdeaPicture = function(){
		// Check for picture name
		
		// NOT NEEDED ANYMORE -> NOW SAVE PICTURE WITH SESSION_ID AND TIME
		/*var idea_title = document.getElementById("idea_form_title").value;
		if(idea_title.trim() == ""){
			alert("Please insert an idea title first.");
			return false;
		}
		var confirm_message = confirm("Once you upload a picture, you cannot change the idea title. Your current idea title is:\n"+idea_title);
		if(!confirm_message){
			return false;
		}

		// Set profile picture name
		document.getElementById("idea_picture_title").setAttribute("value", idea_title);
		*/

		// Call general upload function -> upload.js
		return upload_form_submit();
	}

	this.uploadIdeaPictureCallback = function(filename, dir){

		// Set picture name in the idea form
		document.getElementById("idea_form_avatar").setAttribute("value", filename);
		// Call general upload function -> upload.js
		render_picture_callback(filename, dir, true);
		// Hide upload picure section
		this.layout.toggleIdeaPictureForm();
		// fix the background size of the target-picture (temporary fix)
		var tp = document.getElementById("target_picture"),
			tp_style = tp.getAttribute("style");
		tp.setAttribute("style", tp_style + ";background-size:cover;")
	
	}

	var publishCallback = function(response) {
		
		if(response == "ok"){
			alert("Congrats! You published a new idea");
			// Refresh the page
			location.reload(); 
		} else {
			alert(response);
		}
		
		// Hide loader
		Sp.layout.hideLoading();
	}

	this.publishIdea = function(switch_,idea_id) {

		//var confirm_message = "Please double check your data.\nOnce published it is not possible to edit the idea.";

		//if(!confirm(confirm_message)) {
		//	return false;
		//}

		// Set parameters
		var title = document.getElementById("idea_form_title").value;
		//team_size = document.getElementById("idea_form_team_size").value;
		var description = document.getElementById("idea_form_description").value;
		var avatar = document.getElementById("idea_form_avatar").value;
		var background_pref = document.getElementById("idea_form_background_pref").value;

		if(switch_==true){
			var parameters = "key=new_idea";
			var callback = publishCallback;
		} else {
			var parameters = "key=edit_idea&idea_id="+idea_id;
			var callback = editIdeaCallback;
		}
		parameters += "&title=" + title;
		//parameters += "&team_size=" + team_size;
		parameters += "&description=" + description;
		parameters += "&avatar=" + avatar;
		parameters += "&background_pref=" + background_pref;

		var url = IDEA_MANAGE_CONTROLLER;
		
		// Display loader
		Sp.layout.showLoading();

		// Send post request
		Sp.post({url : url, parameters : parameters}, callback);

		// Prevent the form to reload the page
		return false;

	}


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



StartuppuccinoIdeas.prototype.layout = {};

StartuppuccinoIdeas.prototype.layout.toggleIdeaPictureForm = function() {
    var search = document.getElementsByClassName("picture_form_wrapper")[0];
    search.classList.toggle("picture_form_wrapper--visible");
}
StartuppuccinoIdeas.prototype.layout.setFooterOverlayLoader = function(elem, flag) {
	if(flag === true){
		elem.className = "overlay_loader overlay_loader--block";
	} else {
		elem.className = "overlay_loader";
	}
}

/* Initialize Startuppuccino Home */

if(typeof SpIdea === "undefined" || SpIdea === null){

	var SpIdea = new StartuppuccinoIdeas();

}


/* Add event listeners */

window.addEventListener("load", function(){

	var idea_form = document.getElementById("idea_form"),
		picture_form = document.getElementById("idea_form_picture_upload"),
		picture_form_trigger = document.getElementById("target_picture"),
		delete_idea_buttons = document.getElementsByClassName("delete_idea_button"),
		comment_idea_buttons = document.getElementsByClassName("comment_idea_button");


	var delete_idea_buttons_length = delete_idea_buttons.length,
	    comment_idea_buttons_length = comment_idea_buttons.length;


	// Idea form is display only in the first phase
	if(typeof idea_form != "undefined" && 
	   idea_form != null){
		
		document.getElementById("idea_form").onsubmit = function(){
				return SpIdea.publishIdea(true,'');
			};

		picture_form.onsubmit = function(){
				return SpIdea.uploadIdeaPicture();
			};

		picture_form_trigger.addEventListener("click", function(){ SpIdea.layout.toggleIdeaPictureForm(); });

		for (var i = 0; i < delete_idea_buttons_length; i++) {
			delete_idea_buttons[i].addEventListener("click", function(e){ SpIdea.deleteIdea(e); });
		}
		for (var i = 0; i < comment_idea_buttons_length; i++) {
			comment_idea_buttons[i].addEventListener("click", function(e){ SpIdea.showCommentBox(e); });
		}
	}

});