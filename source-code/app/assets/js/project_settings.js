
function StartuppuccinoProjectSettings(){

	var TARGET_URL = "../app/controllers/manage_project_settings.php";

	this.saveInput = function(e){

		var button = e.target || e.srcElement,
		    id = button.getAttribute("data-for")
		    value = button.value,
		    name = button.getAttribute("name");

		var parameters = "id="+id+"&value="+value+"&name="+name+"&project_id="+PROJECT_ID;

		Sp.post({url: TARGET_URL, parameters: parameters}, function(response){

			if(response == "ok"){
				SpProjectSettings.layout.showTinyLoader(id);
			} else {
				alert(response);
			}

		});

	}

	this.enableSaver = function(e){

		var button = e.target || e.srcElement,
		    id = button.getAttribute("id");

		SpProjectSettings.layout.hideTinyLoader(id);

	}

}

StartuppuccinoProjectSettings.prototype.layout = {};
StartuppuccinoProjectSettings.prototype.layout.hideTinyLoader = function(id) {
	document.getElementById(id+"_loader").setAttribute("style","display:none");
}
StartuppuccinoProjectSettings.prototype.layout.showTinyLoader = function(id) {
	document.getElementById(id+"_loader").removeAttribute("style");
}





function StartuppuccinoProjectChart () {}

StartuppuccinoProjectChart.prototype.showSettings = function() {

	var comment_box = document.getElementsByClassName("project_chart_settings")[0];
	comment_box.className = "project_chart_settings comment_box comment_box--visible";

}
StartuppuccinoProjectChart.prototype.hideSettings = function() {

	var comment_box = document.getElementsByClassName("project_chart_settings")[0];
	comment_box.className = "project_chart_settings comment_box";

}
StartuppuccinoProjectChart.prototype.loadLearningStages = function() {

	Sp.post({
			url : "../app/controllers/manage_project_progress.php",
			parameters : "key=get_learningstages&project_id=" + PROJECT_ID
		}, function(stages){
			document.getElementById("stages_container").innerHTML = stages;
	});

}
StartuppuccinoProjectChart.prototype.submitLearningStage = function(){

	Sp.layout.showLoading();

	var title = document.getElementById("learning_stage__title").value,
		description = document.getElementById("learning_stage__description").value,
		mood = document.getElementById("learning_stage__mood").value;

	if ( title == "" ||
		 description == "" ||
		 mood == "" ) {
		alert("Please fill all the form");
		Sp.layout.hideLoading();
		return false;
	}

	Sp.post({
			url : "../app/controllers/manage_project_progress.php",
			parameters : "key=new_learningstage&project_id=" + PROJECT_ID + 
			             "&title=" + title +
			             "&description=" + description +
			             "&mood=" + mood
		},function(response){
			if(response == "ok"){
				SpProjectChart.loadLearningStages();
				SpProjectChart.hideSettings();
				// Empty textarea
				document.getElementById("learning_stage__title").value = "";
				document.getElementById("learning_stage__description").value = "";
			} else {
				alert(response);
			}
			// Hide loader
			Sp.layout.hideLoading();
		});

	return false;
}
StartuppuccinoProjectChart.prototype.mentor = {};
StartuppuccinoProjectChart.prototype.mentor.setLearningstageStatus = function(button, status) {

	var stage_id = button.getAttribute("stage-id");

	Sp.layout.showLoading();

	Sp.post({
		url : "../app/controllers/manage_project_progress.php",
		parameters : "key=set_learningstage_status&project_id=" + PROJECT_ID +
					 "&status=" + status + "&stage_id=" + stage_id
	},function(response){
		if ( response == "ok" ) {
			SpProjectChart.loadLearningStages();
		} else {
			alert(response);
		}
		Sp.layout.hideLoading();
	});

}


/* Initialize Startuppuccino Project Chart */

if(typeof SpProjectChart === "undefined" || SpProjectChart === null){

	var SpProjectChart = new StartuppuccinoProjectChart();

}



/* Initialize Startuppuccino Project Settings */

if(typeof SpProjectSettings === "undefined" || SpProjectSettings === null){

	var SpProjectSettings = new StartuppuccinoProjectSettings();

}

/* Add event listeners */

window.addEventListener("load", function(){

	var saver_buttons = document.getElementsByClassName("settings__input__save_button"),
	    inputs_ = document.getElementsByClassName("settings__input__content");

	var saver_buttons_length = saver_buttons.length,
	    inputs_length = inputs_.length;
	
	for (var i = 0; i < saver_buttons_length; i++) {
		saver_buttons[i].addEventListener("click", function(e){ SpProjectSettings.saveInput(e); });
	}
	for (var i = 0; i < inputs_length; i++) {
		inputs_[i].addEventListener("input", function(e){ SpProjectSettings.enableSaver(e); });
	}

});