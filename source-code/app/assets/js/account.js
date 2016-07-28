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
	
	socialdata = [];
	// Collect data
	inputs = document.getElementsByClassName("social");
	for (var i = 0; i <= inputs.length; i++) {
		if(inputs[i]){
			childs = inputs[i].childNodes;
			for (var k = childs.length - 1; k>= 0; k--) {
				if(childs[k].tagName == "label"){
				} else if(childs[k].getAttribute("socialname") == "link") {
					social[1] = childs[k].value;
				} else if(childs[k].getAttribute("socialname") == "priority") {
					if(childs[k].checked){
						social[2] = "primary";
					} else {
						social[2] = "secondary";
					}
				}
			}
			socialdata.push(social);
		}
	};

	alert(JSON.stringify(socialdata));

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
	xmlhttp.setRequestHeader("Content-type", "application/json; charset=utf-8");//"application/x-www-form-urlencoded");
	xmlhttp.send("socialdata="+socialdata);

}