function checkForm(){
	// Add here some client checks to prevent bad ux
	// If you want to block -> return false;
	// If you want to proceed with post submitting -> return true;

	// Check if old and new password match
	if(document.getElementById('password_input_1').value != document.getElementById('password_input_2').value){
		return true;
	} else {
		alert("Old and new password are the same!");
		// reset new password input
		document.getElementById('password_input_2').value = "";
		return false;
	}
}

function saveSocialInputs(){
	// Collect all data and send them at server script "social_link_controller.php"

	// Socials array example:
	// ["facebook"=>["https://facebook.com/user/helloworld","primary"],"twitter"=>["https://twitter.com/user/helloworld","secondary"]]
	
	// Initialize empty object
	socialdata = {};
	// Collect data and push into object socialdata
	inputs = document.getElementsByClassName("social");
	for (var i = 0; i <= inputs.length; i++) {
		if(!(social = inputs[i])){
			continue;
		}

		// Get social label
		label = social.getAttribute("id");
		// Check if the social link is set
		if(!(link = document.getElementById(label+"_link").value) || link.trim()==""){
			continue;
		}

		// Get the priority of the social
		if(document.getElementById(label+"_priority").checked){
			priority = "primary";
		} else {
			priority = "secondary";
		}

		// Push
		socialdata[label] = [link,priority];
	};

	// Format object into json
	socialdata = JSON.stringify(socialdata);

	// Send data to server
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	        console.log(xmlhttp.responseText);
	        if(xmlhttp.responseText=="ok"){
	        	alert("Data saved");
	        	hideSocialBox();
	        } else {
	        	alert(xmlhttp.responseText);
	        }
	    }
	};
	xmlhttp.open("POST", "./social_link_controller.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("socialdata="+socialdata);

}