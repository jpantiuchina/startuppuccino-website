
/* JOIN & LEAVE */

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
	
		} else {

			alert("Error js: action not set. "+action);

		}

		// Async update team size
		connectPOST("./manage_ideas.php","key=teamsize&idea_id="+IDEA_ID,"idea_teamsize");
	
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

function editIdea() {
	// ... still to  implement
	// Does it make sense to update an idea? Or this is just another idea?
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


function publishIdea() {

	var confirm_message = "Please double check your data.\nOnce published it is not possible to edit the idea.";

	if(!confirm(confirm_message)) {
		return false;
	}

	// Set parameters
	var title = document.getElementById("idea_form_title").value;
	//team_size = document.getElementById("idea_form_team_size").value;
	var description = document.getElementById("idea_form_description").value;
	var avatar = document.getElementById("idea_form_avatar").value;
	var background_pref = document.getElementById("idea_form_background_pref").value;

	var parameters = "key=new_idea";
	parameters += "&title=" + title;
	//parameters += "&team_size=" + team_size;
	parameters += "&description=" + description;
	parameters += "&avatar=" + avatar;
	parameters += "&background_pref=" + background_pref;

	var url = "./manage_ideas.php";
	var callback = "new_idea";

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