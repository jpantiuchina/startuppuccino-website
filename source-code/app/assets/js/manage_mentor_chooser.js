/* Ideas class */
function StartuppuccinoMentorChooser(){

	/* JOIN & LEAVE / LIKE & UNLIKE */

	var BUTTON_SELECTED,
	    MENTOR_ID,
	    CONTROLLER_DIR = "../app/controllers/",
	    IDEA_MANAGE_CONTROLLER = CONTROLLER_DIR + "manage_mentor_chooser.php";

	this.ideaHelper = function(action, mentor_id, dom_element){
		
		// show the loading
		Sp.layout.showLoading();

		// save temporary the button and idea selected
		BUTTON_SELECTED = dom_element;
		MENTOR_ID = mentor_id;

		// send data to server
		var data = {
			url : IDEA_MANAGE_CONTROLLER,
			parameters : "key=" + action + "_mentor&mentor_id=" + mentor_id
		}

		Sp.post(data, function(response){

				if(response == "ok"){

					if (action == "like"){

						// Change style to the button
						BUTTON_SELECTED.value = "Un-choose";
						BUTTON_SELECTED.className = "c_red st_button";
						BUTTON_SELECTED.style = "background-color: #f00";
						
						// Update click listener from the button
						BUTTON_SELECTED.setAttribute("onclick", "SpMentorChooser.ideaHelper('unlike','" + MENTOR_ID + "',this);");
				
					} else if (action == "unlike"){

						// Change style to the button
						BUTTON_SELECTED.value = "Choose";
						BUTTON_SELECTED.className = "c_green st_button";
						BUTTON_SELECTED.style = "";
						
						// Update click listener from the button
						BUTTON_SELECTED.setAttribute("onclick", "SpMentorChooser.ideaHelper('like','" + MENTOR_ID + "',this);");
				
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


/* Initialize Startuppuccino Project Chooser */

if(typeof SpMentorChooser === "undefined" || SpMentorChooser === null){

	var SpMentorChooser = new StartuppuccinoMentorChooser();

}