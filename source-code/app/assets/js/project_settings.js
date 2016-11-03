
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