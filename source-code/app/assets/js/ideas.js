
/* Set event listeners */

document.getElementById("idea_form_picture_upload").onsubmit = function(){
	return SpIdea.uploadIdeaPicture();
}

document.getElementById("idea_form").onsubmit = function(){
	return SpIdea.publishIdea(true,'');
}


/* Ideas class */

var SpIdea = new function(){

	/* JOIN & LEAVE / LIKE & UNLIKE */

	var BUTTON_SELECTED;
	var IDEA_ID;
	var TEAMSIZE_NODE;

	this.ideaHelper = function(action, idea_id, dom_element){
		
		// show the loading
		Sp.layout.showLoading();

		// save temporary the button and idea selected
		BUTTON_SELECTED = dom_element;
		IDEA_ID = idea_id;
		TEAMSIZE_NODE = document.getElementById("team_" + idea_id);

		// send data to server
		var data = {
			url : "./manage_ideas.php",
			parameters : "key=" + action + "_idea&idea_id=" + idea_id
		}

		Sp.post(data, function(response){

				if(response == "ok"){

					if(action == "join"){

						// Change style to the button
						BUTTON_SELECTED.innerHTML = "LEAVE IDEA";

						// Update click listener from the button
						BUTTON_SELECTED.setAttribute("onclick", "SpIdea.ideaHelper('leave','" + IDEA_ID + "',this);");

					} else if (action == "leave"){

						// Change style to the button
						BUTTON_SELECTED.innerHTML = "JOIN IDEA";
						
						// Update click listener from the button
						BUTTON_SELECTED.setAttribute("onclick", "SpIdea.ideaHelper('join','" + IDEA_ID + "',this);");
				
					} else if (action == "like"){

						// Change style to the button
						BUTTON_SELECTED.innerHTML = "UNLIKE";
						
						// Update click listener from the button
						BUTTON_SELECTED.setAttribute("onclick", "SpIdea.ideaHelper('unlike','" + IDEA_ID + "',this);");
				
					} else if (action == "unlike"){

						// Change style to the button
						BUTTON_SELECTED.innerHTML = "LIKE";
						
						// Update click listener from the button
						BUTTON_SELECTED.setAttribute("onclick", "SpIdea.ideaHelper('like','" + IDEA_ID + "',this);");
				
					} else {

						alert("Error js: action not set. "+action);

					}

					if(action !="like" && action != "unlike"){
						// Async update team size
						Sp.post({
								url : "./manage_ideas.php",
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

	this.deleteIdea = function(idea_id) {

		var confirmMessage = "!!! Attention !!!\nAre you sure you want to delete this idea?";

		if (confirm(confirmMessage)){
			
			Sp.post({
					url : "./manage_ideas.php",
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

	// Optimize and remove this code to manage visible sections
	this.showIdeaForm = function(){
		document.getElementById("new_idea__section").style.display = "block";
	}

	this.hideIdeaForm = function(){
		document.getElementById("new_idea__section").style.display = "none";
	}

	this.openNewIdeaForm = function(){

		// Reset inputs
		document.getElementById("idea_form_title").setAttribute("value","");
		document.getElementById("idea_form_description").innerHTML = "";
		document.getElementById("idea_form_avatar").setAttribute("value","");
		document.getElementById("idea_form_background_pref").setAttribute("value","");
		document.getElementById("target_picture").setAttribute("src","");
		//document.getElementById("idea_form").setAttribute("onsubmit","return SpIdea.publishIdea(true,'');");

		// Show form
		this.showIdeaForm();
	}

	this.uploadIdeaPicture = function(){
		// Check for picture name
		var idea_title = document.getElementById("idea_form_title").value;
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

		// Call general upload function -> upload.js
		return upload_form_submit();
	}

	this.uploadIdeaPictureCallback = function(filename,dir){
		document.getElementById("idea_form_avatar").setAttribute("value", filename);
		// Call general upload function -> upload.js
		render_picture_callback(filename,dir);   
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

		var url = "./manage_ideas.php";
		
		// Display loader
		Sp.layout.showLoading();

		// Send post request
		Sp.post({url : url, parameters : parameters}, callback);

		// Prevent the form to reload the page
		return false;

	}


	/* COMMENTS */

	this.submitComment = function(form){

		var idea_id = form.getAttribute("ideaid");

		var comment = document.getElementById("comment_textarea").innerHTML;
		if(comment==""){
			alert("Your comment is empty");
			return false;
		}

		Sp.post({
				url : "./manage_ideas.php",
				parameters : "key=new_comment&idea_id=" + idea_id + "&comment=" + comment
			},function(response){
				if(response == "ok"){
					alert("Comment correctly published");
					// Refresh comments
					this.displayComments(IDEA_ID);
				} else {
					alert(response);
				}
				// Hide loader
				Sp.layout.hideLoading();
			});

		IDEA_ID = idea_id;

		return false;
	}

	this.showComments = function(idea_id){

		// Display comments box
		// ...

		// Set form ideaid
		document.getElementById("comment_box_form").setAttribute("ideaid",idea_id);

		// Load comments of selected idea
		Sp.post({
				url : "./manage_ideas.php",
				parameters : "key=get_comments&idea_id=" + idea_id
			},function(comments){
				// Load comments in the comments box
				document.getElementById("comments").innerHTML = comments;
			});

	}


	this.hideComments = function(){

		// Hide comments box
		// ...

		// Empty comment box
		document.getElementById("comments").innerHTML = "";

	}

}