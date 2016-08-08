
/* JOIN & LEAVE / LIKE & UNLIKE */

var BUTTON_SELECTED;
var IDEA_ID;
var TEAMSIZE_NODE;

function ideaHelper(action, idea_id, dom_element){
	
	// show the loading
	showLoadingScreen();

	// send data to server
	var url = "./manage_ideas.php";
	var parameters = "key="+action+"_idea&idea_id="+idea_id;
	var callback = action+"_idea";
	connectPOST(url,parameters,callback);

	// save temporary the button and idea selected
	BUTTON_SELECTED = dom_element;
	IDEA_ID = idea_id;
	TEAMSIZE_NODE = document.getElementById("team_"+idea_id);

}

function ideaHelperCallback(action, response){

	if(response == "ok"){


		if(action == "join"){

			// Change style to the button
			BUTTON_SELECTED.innerHTML = "LEAVE IDEA";

			// Update click listener from the button
			BUTTON_SELECTED.setAttribute("onclick","ideaHelper('leave','"+IDEA_ID+"',this);");

		} else if (action == "leave"){

			// Change style to the button
			BUTTON_SELECTED.innerHTML = "JOIN IDEA";
			
			// Update click listener from the button
			BUTTON_SELECTED.setAttribute("onclick","ideaHelper('join','"+IDEA_ID+"',this);");
	
		} else if (action == "like"){

			// Change style to the button
			BUTTON_SELECTED.innerHTML = "UNLIKE";
			
			// Update click listener from the button
			BUTTON_SELECTED.setAttribute("onclick","ideaHelper('unlike','"+IDEA_ID+"',this);");
	
		} else if (action == "unlike"){

			// Change style to the button
			BUTTON_SELECTED.innerHTML = "LIKE IDEA";
			
			// Update click listener from the button
			BUTTON_SELECTED.setAttribute("onclick","ideaHelper('like','"+IDEA_ID+"',this);");
	
		} else {

			alert("Error js: action not set. "+action);

		}

		if(action !="like" && action != "unlike"){
			// Async update team size
			connectPOST("./manage_ideas.php","key=teamsize&idea_id="+IDEA_ID,"idea_teamsize");
		}

	} else {

		alert(response);

	}

	// hide loading screen
	hideLoadingScreen();

	// Reset variable button_selected;
	BUTTON_SELECTED = null;

}

function teamsizeCallback(response){

	TEAMSIZE_NODE.innerHTML = "Team size: " + parseInt(response); // +1 is the idea owner

}

/* DELETE */

function deleteIdea(idea_id) {

	confirmMessage = "!!! Attention !!!\nAre you sure you want to delete this idea?";

	if (confirm(confirmMessage)){
		
		connectPOST("./manage_ideas.php","key=delete_idea&idea_id="+idea_id,"delete_idea");
	
	}

}

function deleteIdeaCallback(response) {
	if(response == "ok") {
		alert("Your idea has been deleted");
		location.reload();
	} else {
		alert(response);
	}
}

/* EDIT */

function editIdea(idea_id) {
	// ... still to  implement

	// Set parameters
	document.getElementById("idea_form_title").setAttribute("value",document.getElementById("idea_title__"+idea_id).innerHTML);
	document.getElementById("idea_form_description").innerHTML = document.getElementById("idea_description__"+idea_id).innerHTML;
	document.getElementById("idea_form_avatar").setAttribute("value",document.getElementById("idea_picture__"+idea_id).src);
	document.getElementById("idea_form_background_pref").setAttribute("value",document.getElementById("idea_background__"+idea_id).innerHTML);
	document.getElementById("target_picture").setAttribute("src",document.getElementById("idea_picture__"+idea_id).src);
	document.getElementById("idea_form").setAttribute("onsubmit","return publishIdea(false,'"+idea_id+"');");

	// Open idea form
	showIdeaForm();
	
}

function editIdeaCallback(response){
	if(response == "ok") {
		alert("Your idea has been updated");
		location.reload();
	} else {
		alert(response);
	}	
}

/* PUBLISH */

function showIdeaForm(){
	document.getElementById("new_idea__section").style.display = "block";
}

function hideIdeaForm(){
	document.getElementById("new_idea__section").style.display = "none";
}

function openNewIdeaForm(){

	// Reset inputs
	document.getElementById("idea_form_title").setAttribute("value","");
	document.getElementById("idea_form_description").innerHTML = "";
	document.getElementById("idea_form_avatar").setAttribute("value","");
	document.getElementById("idea_form_background_pref").setAttribute("value","");
	document.getElementById("target_picture").setAttribute("src","");
	document.getElementById("idea_form").setAttribute("onsubmit","return publishIdea(true,'');");

	// Show form
	showIdeaForm();
}

function uploadIdeaPicture(){
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
	document.getElementById("idea_picture_title").setAttribute("value",idea_title);

	return upload_form_submit();
}

function uploadIdeaPictureCallback(filename,dir){
	document.getElementById("idea_form_avatar").setAttribute("value",filename);
	render_picture_callback(filename,dir);   
}


function publishIdea(switch_,idea_id) {

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
		var callback = "new_idea";
	} else {
		var parameters = "key=edit_idea&idea_id="+idea_id;
		var callback = "edit_idea";
	}
	parameters += "&title=" + title;
	//parameters += "&team_size=" + team_size;
	parameters += "&description=" + description;
	parameters += "&avatar=" + avatar;
	parameters += "&background_pref=" + background_pref;

	var url = "./manage_ideas.php";
	
	// Display loader
	showLoadingScreen();

	// Send post request
	connectPOST(url,parameters,callback);

	// Prevent the form to reload the page
	return false;

}

function publishIdeaCallback(response) {
	
	if(response == "ok"){
		alert("Congrats! You published a new idea");
		// Refresh the page
		location.reload(); 
	} else {
		alert(response);
	}
	
	// Hide loader
	hideLoadingScreen();
}


/* COMMENTS */

function submitComment(form){

	var idea_id = form.getAttribute("ideaid");

	var comment = document.getElementById("comment_textarea").innerHTML;
	if(comment==""){
		alert("Your comment is empty");
		return false;
	}

	connectPOST("./manage_ideas.php","key=new_comment&idea_id="+idea_id+"&comment="+comment,"new_comment_idea");

	IDEA_ID = idea_id;

	return false;
}

function submitCommentCallback(response){

	if(response == "ok"){
		alert("Comment correctly published");
		// Refresh comments
		displayComments(IDEA_ID);
	} else {
		alert(response);
	}

	// Hide loader
	hideLoadingScreen();

}

function displayComments(idea_id){

	// Display comments box
	// ...

	// Set form ideaid
	document.getElementById("comment_box_form").setAttribute("ideaid",idea_id);

	// Load comments of selected idea
	connectPOST("./manage_ideas.php","key=get_comments&idea_id="+idea_id,"get_comments_idea");

}


function hideCommentSection(){

	// Hide comments box
	// ...

	// Empty comment box
	// ...

}

function displayCommentsCallback(comments){

	// Load comments in the comments box
	document.getElementById("comments").innerHTML = comments;

}








