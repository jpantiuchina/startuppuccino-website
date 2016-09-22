/* Home class */

function StartuppuccinoHome(){}

/* Layout */

StartuppuccinoHome.prototype.layout = {}

StartuppuccinoHome.prototype.layout.showTinyloader = function(loader){
	loader.setAttribute("style","display:block");
}
StartuppuccinoHome.prototype.layout.hideTinyloader = function(loader){
	loader.setAttribute("style","display:none");	
}
StartuppuccinoHome.prototype.layout.toogleResources = function(session_id) {
		
}
StartuppuccinoHome.prototype.layout.toogleComments = function(session_id) {
		
}
StartuppuccinoHome.prototype.layout.toggleMentorAvailabilityButton = function(session_id, button) {

	var action = button.parentNode.getAttribute("data-action");

	if (action === "add"){

		button.parentNode.childNodes[3].setAttribute("onclick","SpHome.mentors.setAvailability("+session_id+",this)");
		button.parentNode.className = "button_availability action_remove";
		button.parentNode.setAttribute("data-action","remove");
		SpHome.layout.renderGuest(session_id);

	} else if (action === "remove"){
	
		button.parentNode.childNodes[1].setAttribute("onclick","SpHome.mentors.setAvailability("+session_id+",this)");
		button.parentNode.className = "button_availability action_add";
		button.parentNode.setAttribute("data-action","add");
		button.parentNode.parentNode.childNodes[3].childNodes[1].childNodes[1].setAttribute("data-pitch", 1);
		button.parentNode.parentNode.childNodes[3].childNodes[1].childNodes[5].checked = false;
		button.parentNode.parentNode.childNodes[3].childNodes[1].className = "";
		SpHome.layout.renderGuest(session_id, true);

	} else {

		alert("Error, please reload the page.");
		window.location.reload();

	}
}
StartuppuccinoHome.prototype.layout.renderGuest = function(session_id, remove_mentor) {
	
	var id = "guests__" + session_id;

	if(typeof remove_mentor !== "undefined" || remove_mentor === true){

		var guests = document.getElementById(id).childNodes;

		for (var i = 0; i < guests.length; i++) {
			var guest = guests[i];
			if(guest.nodeType === 1	&& guest.getAttribute("guest-id") == STARTUPPUCCINO_USER.id){
				guest.parentNode.removeChild(guest);
			}
		}

	} else {

		var guest = document.createElement("div");
		var link = document.createElement("a");
		var img = document.createElement("div");
		
		guest.className = "guest";
		guest.setAttribute("guest-id",STARTUPPUCCINO_USER.id);
		link.setAttribute("href","../people/?user_id="+STARTUPPUCCINO_USER.id);
		img.setAttribute("style","background-image:url('../app/assets/pics/people/"+STARTUPPUCCINO_USER.avatar);

		link.appendChild(img);
		guest.appendChild(link);
		document.getElementById(id).appendChild(guest);

	}

}
StartuppuccinoHome.prototype.layout.setPitchButton = function(button, pitch){

	if(pitch === "1"){
		button.setAttribute("data-pitch","0");
		button.parentNode.className = "checked";
	} else {
		button.setAttribute("data-pitch","1");
		button.parentNode.className = "";
	}

}

/* Mentors functionality */

StartuppuccinoHome.prototype.mentors = {}

StartuppuccinoHome.prototype.mentors.setAvailability = function(session_id, button) {

	var loader = button.parentNode.parentNode.childNodes[5];
	var action = button.parentNode.getAttribute("data-action");
	var data = {};

	// Show loader -> try to prevent double click on button
	SpHome.layout.showTinyloader(loader);

	data.url = "../app/controllers/mentors_availability.php";
	data.parameters = "s_id="+session_id+"&action="+action;

	Sp.post(
		data,
		function(response){
			if(response == "ok") {
				SpHome.layout.toggleMentorAvailabilityButton(session_id, button);
			} else {
				alert(response);
			}
			// Hide loader
			SpHome.layout.hideTinyloader(loader);
		});

}
StartuppuccinoHome.prototype.mentors.setPitch = function(e){

	var button = e.target || e.srcElement,
		loader = button.parentNode.parentNode.parentNode.childNodes[5];
		session_id = button.getAttribute("data-session");
		pitch = button.getAttribute("data-pitch");
		action = button.parentNode
				       .parentNode
				       .parentNode.childNodes[1].getAttribute("data-action");

	var data = {};

	// Show loader -> try to prevent double click on button
	SpHome.layout.showTinyloader(loader);

	data.url = "../app/controllers/mentors_availability.php";
	data.parameters = "s_id=" + session_id + 
	                  "&action=" + action + 
	                  "&pitch=" + pitch ;

	Sp.post(
		data,
		function(response){
			if(response == "ok") {
				if(action == "add"){
					var availbility_button = button.parentNode
					                               .parentNode
					                               .parentNode
					                               .childNodes[1]
					                               .childNodes[3];
					SpHome.layout.toggleMentorAvailabilityButton(session_id, availbility_button);
				}
				SpHome.layout.setPitchButton(button, pitch);
				// Hide loader
				SpHome.layout.hideTinyloader(loader);
			} else {
				console.log(response);
			}
		});

}


/* Initialize Startuppuccino Home */

if(typeof SpHome === "undefined" || SpHome === null){ 

    var SpHome = new StartuppuccinoHome();

}

/* Add event listeners */

window.onload = function(){

	var pitch_toggle_buttons = document.getElementsByClassName("button_toggle_pitch");

	for (var i = 0; i < pitch_toggle_buttons.length; i++) {
		pitch_toggle_buttons[i].addEventListener("click", function(e){ SpHome.mentors.setPitch(e); });
	}


}