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

function displaySocialBox(){
	document.getElementById("social_box").style = "display:block";
}

function hideSocialBox(){
	document.getElementById("social_box").style = "display:none";	
}

function renderNewSocialInput(ind,elem){
	// Add new inputs set in the social_box for one more social
	node = document.createElement("li");
	node_label = document.createElement("input");
	node_link = document.createElement("input");
	node_priority = document.createElement("input");
	node_wrap_priority = document.createElement("label");
	node.setAttribute("class","social");
	node.setAttribute("socialname",ind);
	node_label.setAttribute("type","text");
	node_label.setAttribute("socialname","label");
	node_label.setAttribute("placeholder","Label (ex: Facebook, Google, ..)");
	node_link.setAttribute("type","link");
	node_link.setAttribute("socialname","link");
	node_link.setAttribute("placeholder","Url");
	node_priority.setAttribute("type","checkbox");
	node_priority.setAttribute("socialname","priority");

	node_wrap_priority.appendChild(node_priority);
	node_wrap_priority.appendChild(document.createTextNode("Favorite"));
	node.appendChild(node_label);
	node.appendChild(node_link);
	node.appendChild(node_wrap_priority);
	document.getElementById("new_inputs_box").appendChild(node);

	elem.setAttribute("onclick","renderNewSocialInput("+(ind+1)+",this)");
}

function saveSocialInputs(){
	// Collect all data and send them at server script "save_social_links.php"

	// Socials array example:
	// [["facebook","https://facebook.com/user/helloworld","primary"],["twitter","https://twitter.com/user/helloworld","secondary"]]

	socialdata = [];
	// Collect data
	inputs = document.getElementsByClassName("social");
	for (var i = 0; i <= inputs.length; i++) {
		if(inputs[i]){
			childs = inputs[i].childNodes;
			social = [];
			for (var k = childs.length - 1; k>= 0; k--) {
				if(childs[k].getAttribute("socialname") == "label"){
					social[0] = childs[k].value;
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

	alert(socialdata);

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