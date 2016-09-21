/* Home class */

function StartuppuccinoHome(){}

/* Layout */

StartuppuccinoHome.prototype.layout = {}

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
		button.parentNode.parentNode.childNodes[3].childNodes[1].childNodes[5].removeAttribute("checked");
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

/* Mentors functionality */

StartuppuccinoHome.prototype.mentors = {}

StartuppuccinoHome.prototype.mentors.setAvailability = function(session_id, button) {

	var action = button.parentNode.getAttribute("data-action");
	var data = {};

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
		});

}


/* Initialize Startuppuccino Home */

if(typeof SpHome === "undefined" || SpHome === null){ 

    var SpHome = new StartuppuccinoHome();

}