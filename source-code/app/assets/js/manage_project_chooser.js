/* Ideas class */
function StartuppuccinoProjectChooser(){

	/* JOIN & LEAVE / LIKE & UNLIKE */

	var BUTTON_SELECTED,
	    PROJECT_ID,
	    CONTROLLER_DIR = "../app/controllers/",
	    IDEA_MANAGE_CONTROLLER = CONTROLLER_DIR + "manage_startups_project.php";

	this.ideaHelper = function(action, project_id, dom_element){
		
		// show the loading
		Sp.layout.showLoading();

		// save temporary the button and idea selected
		BUTTON_SELECTED = dom_element;
		PROJECT_ID = project_id;
		TEAMSIZE_NODE = document.getElementById("team_" + project_id);

		// send data to server
		var data = {
			url : IDEA_MANAGE_CONTROLLER,
			parameters : "key=" + action + "_project&project_id=" + project_id
		}

		Sp.post(data, function(response){

				if(response == "ok"){

					if (action == "like"){

						// Change style to the button
						BUTTON_SELECTED.value = "Unlike";
						BUTTON_SELECTED.className = "c_red st_button";
						
						// Update click listener from the button
						BUTTON_SELECTED.setAttribute("onclick", "SpProjectChooser.ideaHelper('unlike','" + PROJECT_ID + "',this);");
				
					} else if (action == "unlike"){

						// Change style to the button
						BUTTON_SELECTED.value = "Like";
						BUTTON_SELECTED.className = "c_green st_button";
						
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


/* Initialize Startuppuccino Project Chooser */

if(typeof SpProjectChooser === "undefined" || SpProjectChooser === null){

	var SpProjectChooser = new StartuppuccinoProjectChooser();

}