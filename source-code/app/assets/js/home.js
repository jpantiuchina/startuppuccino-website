/* Home class */

function StartuppuccinoHome(){}

/* Layout */

StartuppuccinoHome.prototype.layout = {}

StartuppuccinoHome.prototype.layout.toogleResources = function(session_id) {
		
}
StartuppuccinoHome.prototype.layout.toogleComments = function(session_id) {
		
}
StartuppuccinoHome.prototype.layout.toggleMentorAvailabilityButton = function(button) {
	
	var action = button.getAttribute("data-action");

	if (action === "add"){

		button.setAttribute("data-action","remove");
		button.innerHTML = "YES";
		button.className = "c_green";

	} else if (action === "remove"){
	
		button.setAttribute("data-action","add");
		button.innerHTML = "NO";
		button.className = "c_red";

	} else {

		alert("Error, please reload the page.");
		window.location.reload();

	}

}

/* Mentors functionality */

StartuppuccinoHome.prototype.mentors = {}

StartuppuccinoHome.prototype.mentors.setAvailability = function(session_id, button) {

	var action = button.getAttribute("data-action");
	var data = {};

	data.url = "../app/controllers/mentors_availability.php";
	data.parameters = "s_id="+session_id+"&action="+action;

	Sp.post(
		data,
		function(response){
			if(response == "ok") {
				SpHome.layout.toggleMentorAvailabilityButton(button);
			} else {
				alert(response);
			}
		});

}


/* Initialize Startuppuccino Home */

if(typeof SpHome === "undefined" || SpHome === null){ 

    var SpHome = new StartuppuccinoHome();

}