
var button_selected;

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

}

function joinIdeaCallback(response){

	if(response == "ok"){

		// Change style to the button
		button_selected.innerHTML = "Joined";
		button_selected.classList.add("card__button--nobackground");

		// Remove click listener from the button
		button_selected.removeAttribute("onclick");
	
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