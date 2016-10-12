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
StartuppuccinoHome.prototype.layout.toogleResources = function(e) {

	var button = e.target || e.srcElement;
	var session_id = button.parentNode.getAttribute("data-session");
	var resources = button.parentNode.parentNode.childNodes[9];
	comments = button.parentNode.parentNode.childNodes[11];

	resources.classList.toggle("r_show");
	comments.classList.remove("c_show");

}
StartuppuccinoHome.prototype.layout.toogleComments = function(e) {

	var button = e.target || e.srcElement;
	var session_id = button.parentNode.getAttribute("data-session");
	var resources = button.parentNode.parentNode.childNodes[9];
	comments = button.parentNode.parentNode.childNodes[11];

	comments.classList.toggle("c_show");
	resources.classList.remove("r_show");

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
		//button.parentNode.parentNode.childNodes[3].childNodes[1].childNodes[1].setAttribute("data-pitch","0");
		//button.parentNode.parentNode.childNodes[3].childNodes[1].childNodes[5].checked = false;
		//button.parentNode.parentNode.childNodes[3].childNodes[1].className = "";
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

	if(pitch !== 1){
		button.setAttribute("data-pitch","0");
		button.parentNode.className = "";
	} else {
		button.setAttribute("data-pitch","1");
		button.parentNode.className = "checked";
	}

}

/* Mentors functionality */

StartuppuccinoHome.prototype.mentors = {}

StartuppuccinoHome.prototype.mentors.setAvailability = function(e) {

	var button = e.target || e.srcElement,
	    loader = button.parentNode.parentNode.childNodes[3],
	    session_id = button.parentNode.getAttribute("data-session"),
	    action = button.parentNode.getAttribute("data-action"),
	    data = {};

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
		loader = button.parentNode.parentNode.parentNode.childNodes[5],
		session_id = button.getAttribute("data-session"),
		pitch = button.getAttribute("data-pitch"),
		pitch_title = "",
		action = button.parentNode
			.parentNode
			.parentNode.childNodes[1].getAttribute("data-action");

	var data = {};

	// Show loader -> try to prevent double click on button
	SpHome.layout.showTinyloader(loader);

	if( pitch === "3" ){
		if( !confirm("Are you sure you want to withdraw your pitch proposal?") ){
			SpHome.layout.hideTinyloader(loader);
			return;
		}
	}

	if( pitch === "2" ){
		alert("The pitch for this session has already been assigned.");
		SpHome.layout.hideTinyloader(loader);
		return;
	}

	// Set right pitch value
	if( pitch === "0"){
		pitch = 1;
	} else {
		pitch = 0
	}

	// When applying for the pitch, ask for pitch title
	if( pitch === 1 ){

		var pitch_title = prompt("Write here your pitch title proposal...","");

		if( pitch_title == null || pitch_title.trim() === "" ){
			alert("You need to insert a title of your pitch.");
			SpHome.layout.hideTinyloader(loader);
			return;
		}

		if( !confirm("Your pitch title is:\n"+pitch_title) ){
			SpHome.layout.hideTinyloader(loader);
			return;
		}
	}

	data.url = "../app/controllers/mentors_availability.php";
	data.parameters = "s_id=" + session_id +
		"&action=" + action +
		"&pitch=" + pitch +
		"&pitch_title=" + pitch_title;

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

/* Session functionalities */
StartuppuccinoHome.prototype.session = {}

StartuppuccinoHome.prototype.session.publishComment = function(e){

	var button = e.target || e.srcElement,
		session_id = button.getAttribute("data-session"),
		text = button.parentNode.parentNode.childNodes[1].value,
		loader = button.parentNode.parentNode.childNodes[5];

	if(text == ""){
		return;
	}

	var data = {};

	// Show loader -> try to prevent double click on button
	SpHome.layout.showTinyloader(loader);

	data.url = "../app/controllers/course_sessions_comments.php";
	data.parameters = "s_id=" + session_id +
		"&comment_text=" + text +
		"&new=new";

	Sp.post(
		data,
		function(response){
			if(response == "ok") {
				// Reload the page to see the new comments
				if(confirm("Comment published!\nReload the page to see your new comment.")){
					window.location.reload();
				}
			} else {
				alert(response);
				console.log(response);
			}
			// Hide loader
			SpHome.layout.hideTinyloader(loader);
		});

}
StartuppuccinoHome.prototype.session.deleteComment = function(e){

	var button = e.target || e.srcElement,
		session_id = button.getAttribute("data-session"),
		comment_id = button.parentNode.parentNode.getAttribute("comment-id"),
		comment_text = button.parentNode.parentNode.childNodes[3].innerHTML;

	if( !confirm("Do you really want to delete this comment?\n\n" + comment_text) ){
		return;
	}

	var data = {};

	// Show loader -> try to prevent double click on button
	Sp.layout.showLoading();

	data.url = "../app/controllers/course_sessions_comments.php";
	data.parameters = "s_id=" + session_id +
		"&comment_id=" + comment_id +
		"&delete=delete";

	Sp.post(
		data,
		function(response){
			// Hide loader
			Sp.layout.hideLoading();
			if(response == "ok") {
				// Reload the page to see the new comments
				if(confirm("Comment deleted!\nReload the page to update the comments.")){
					window.location.reload();
				}
			} else {
				alert(response);
				console.log(response);
			}
		});

}
StartuppuccinoHome.prototype.session.scrollToSection = function(e){

	e.preventDefault();

	var element = e.target || e.srcElement,
		element_id,
		element_id_ = element.getAttribute("href");

	// Patch if clicked on <a> child nodes
	if(element_id_ == null){
		element = element.parentNode;
		element_id_ = element.getAttribute("href");
	}

	element_id = element_id_.substr(1);

	Sp.helpers.scrollTo(element_id, 200, document.getElementsByTagName("header")[0].offsetHeight);

	// highlight selected session
	var sessions = document.getElementsByClassName("session"),
		sessions_length = sessions.length;
	for (var i = 0; i < sessions_length; i++) {
		sessions[i].className = "session";
	}
	document.getElementById(element_id).className = "session session--highlight";
}



/* Initialize Startuppuccino Home */

if(typeof SpHome === "undefined" || SpHome === null){

	var SpHome = new StartuppuccinoHome();

}

/* Add event listeners */

window.addEventListener("load", function(){

	var availability_buttons = document.getElementsByClassName("button_availability"),
	    pitch_toggle_buttons = document.getElementsByClassName("button_toggle_pitch"),
	    resources_toggle_buttons = document.getElementsByClassName("session_resources_button"),
	    comments_toggle_buttons = document.getElementsByClassName("session_comments_button"),
	    publish_comments_buttons = document.getElementsByClassName("publish_comment_button"),
	    delete_comments_buttons = document.getElementsByClassName("comment__delete"),
	    session_sidebar_links = document.getElementsByClassName("sessions_sidebar_link");

	var availability_length = availability_buttons.length,
	    pitch_length = pitch_toggle_buttons.length,
	    resources_length = resources_toggle_buttons.length,
	    comments_length = comments_toggle_buttons.length,
	    publish_comments_length = publish_comments_buttons.length,
	    delete_comments_length = delete_comments_buttons.length,
	    session_sidebar_links_length = session_sidebar_links.length;

	for (var i = 0; i < availability_length; i++) {
		availability_buttons[i].addEventListener("click", function(e){ SpHome.mentors.setAvailability(e); });
	}
	for (var i = 0; i < pitch_length; i++) {
		pitch_toggle_buttons[i].addEventListener("click", function(e){ SpHome.mentors.setPitch(e); });
	}
	for (var i = 0; i < resources_length; i++) {
		resources_toggle_buttons[i].addEventListener("click", function(e){ SpHome.layout.toogleResources(e); });
	}
	for (var i = 0; i < comments_length; i++) {
		comments_toggle_buttons[i].addEventListener("click", function(e){ SpHome.layout.toogleComments(e); });
	}
	for (var i = 0; i < publish_comments_length; i++) {
		publish_comments_buttons[i].addEventListener("click", function(e){ SpHome.session.publishComment(e); });
	}
	for (var i = 0; i < delete_comments_length; i++) {
		delete_comments_buttons[i].addEventListener("click", function(e){ SpHome.session.deleteComment(e); });
	}
	for (var i = 0; i < session_sidebar_links_length; i++) {
		session_sidebar_links[i].addEventListener("click", function(e){ SpHome.session.scrollToSection(e); });
	}

});