
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
	
	Sp.layout.showLoading();

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
	socialdata_o = socialdata;
	socialdata = JSON.stringify(socialdata);

	// Look for edits in social data
	if ( socialdata == JSON.stringify(CURRENT_SOCIALS) ){

		alert("Social data saved");

		Sp.layout.hideLoading();

	} else {

		// Send data to server
		Sp.post({
					url: "../app/controllers/social_link_controller.php",
					parameters: "socialdata="+socialdata
				}, function(response){
					if( response == "ok" ){
						CURRENT_SOCIALS = socialdata_o;
			        	alert("Social data saved");
			        } else {
			        	alert(response);
			        }
		        	Sp.layout.hideLoading();
				});

	}

}