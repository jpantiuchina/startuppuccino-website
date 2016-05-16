
var button_selected;
var ideaID;

var team_size_node;

// TODO: Refactor --> use OO for general js and management of callbacks

function showIdeaForm(){
	document.getElementById("new_idea__section").style.display = "block";
}

function hideIdeaForm(){
	document.getElementById("new_idea__section").style.display = "none";
}

function ideaHelper(action, idea_id, dom_element){
	
	// show the loading
	showLoadingScreen();

	// send data to server to be
	url = "./manage_ideas.php";

	if(action == "join"){

		parameters = "key=join_idea&idea_id="+idea_id;
		callback = "join_idea";

	} else if(action == "leave"){

		parameters = "key=leave_idea&idea_id="+idea_id;
		callback = "leave_idea";

	}	
	
	connectPOST(url,parameters,callback);

	// save temporary the button and idea selected
	button_selected = dom_element;
	ideaID = idea_id;
	team_size_node = document.getElementById("team_"+idea_id);

}

function ideaHelperCallback(action, response){

	if(response == "ok"){


		if(action == "join"){

			// Change style to the button
			button_selected.innerHTML = "LEAVE IDEA";

			// Update click listener from the button
			button_selected.setAttribute("onclick","ideaHelper('leave','"+ideaID+"',this);");

		} else if (action == "leave"){

			// Change style to the button
			button_selected.innerHTML = "JOIN IDEA";
			
			// Update click listener from the button
			button_selected.setAttribute("onclick","ideaHelper('join','"+ideaID+"',this);");
	
		} else {

			alert("Error js: action not set. "+action);

		}

		// Async update team size
		connectPOST("./manage_ideas.php","key=teamsize&idea_id="+ideaID,"idea_teamsize");
	
	} else {

		alert(response);

	}

	// hide loading screen
	hideLoadingScreen();

	// Reset variable button_selected;
	button_selected = null;

}

function teamsizeCallback(response){

	max_team_size = team_size_node.getAttribute("maxteamsize");

	team_size_node.innerHTML = "Team size: " + (parseInt(response)+1) + "/" + max_team_size; // +1 is the idea owner

}

function deleteIdea(idea_id) {

	confirmMessage = "!!! Attention !!!\nAre you sure you want to delete this idea?";

	if (confirm(confirmMessage)){
		url = "./manage_ideas.php";
		parameters = "key=delete_idea&idea_id="+idea_id;
		callback = "delete_idea";
		connectPOST(url,parameters,callback);
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

function updateIdea() {
	// ... still to  implement
}

function updateIdeaCallback(response){
	if(response == "ok") {
		alert("Your idea has been updated");
		location.reload();
	} else {
		alert(response);
	}	
}

function publishIdea() {

	// Set parameters
	title = document.getElementById("idea_form_title").value;
	team_size = document.getElementById("idea_form_team_size").value;
	description = document.getElementById("idea_form_description").value;
	background_pref = document.getElementById("idea_form_background_pref").value;

	parameters = "key=new_idea";
	parameters += "&title=" + title;
	parameters += "&team_size=" + team_size;
	parameters += "&description=" + description;
	parameters += "&background_pref=" + background_pref;

	url = "./manage_ideas.php";
	callback = "new_idea";

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