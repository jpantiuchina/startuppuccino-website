
var button_selected;
var ideaID;

function joinIdea(idea_id, dom_element){

	// show the loading
	showLoadingScreen();

	// send data to server to be
	url = "./manage_ideas.php";
	parameters = "key=join_idea&idea_id="+idea_id;
	callback = "join_idea";
	connectPOST(url,parameters,callback);

	// save the 'pointer' to the button selected
	button_selected = dom_element;
	ideaID = idea_id;

}

function joinIdeaCallback(response){

	if(response == "ok"){

		// Change style to the button
		button_selected.innerHTML = "LEAVE IDEA";

		// Update click listener from the button
		button_selected.setAttribute("onclick","leaveIdea('"+ideaID+"',this);");
	
	} else {

		alert(response);

	}

	// hide loading screen
	hideLoadingScreen();

	// Reset variable button_selected;
	button_selected = null;

}

function leaveIdea(idea_id, dom_element){

	// show the loading
	showLoadingScreen();

	// send data to server to be
	url = "./manage_ideas.php";
	parameters = "key=leave_idea&idea_id="+idea_id;
	callback = "leave_idea";
	connectPOST(url,parameters,callback);

	// save the 'pointer' to the button selected
	button_selected = dom_element;
	ideaID = idea_id;

}

function leaveIdeaCallback(response){

	if(response == "ok"){

		// Change style to the button
		button_selected.innerHTML = "JOIN IDEA";
		
		// Update click listener from the button
		button_selected.setAttribute("onclick","joinIdea('"+ideaID+"',this);");
	
	} else {

		alert(response);

	}

	// hide loading screen
	hideLoadingScreen();

	// Reset variable button_selected;
	button_selected = null;

}

function publishIdea() {
	
	// Set parameters
	title = document.getElementById("idea_form_title").value;
	team_size = document.getElementById("idea_form_team_size").value;
	description = document.getElementById("idea_form_description").innerHTML;
	background_pref = document.getElementById("idea_form_background_pref").value;

	parameters = "key=new_idea";
	parameters += "title=" + title;
	parameters += "&team_size=" + team_size;
	parameters += "&description" + description;
	parameters += "&background_pref" + background_pref;

	url = "./manage_ideas.php";
	callback = "new_idea";

	// Display loader
	showLoadingScreen();

	// Send post request
	connectPOST(url,parameters,callback);

}

function publishIdeaCallback(response) {
	
	if(response == "ok"){
		// Hide loader
		alert("Congrats!");
		hideLoadingScreen();
	} else {
		alert(response);
	}

}