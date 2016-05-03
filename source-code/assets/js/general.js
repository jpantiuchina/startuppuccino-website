// Loading screen
function showLoadingScreen(){
    document.getElementById("loading_screen").style = "display:block";
}

function hideLoadingScreen(){
    document.getElementById("loading_screen").style = "display:none";
}

// Redirect to logout page (note: with this path it doesn't work from the homepage)
function logout() {
    window.location = "../logout/";
}

// helper to set multiple attributes on a node
function setAttributes(element, attrs) {
    for(var key in attrs) {
        element.setAttribute(key, attrs[key]);
    }
}

// http get request to server with callback
// NOTE: we use the switchCallback function to call the real function,
//		 the parameter callback is only a string used as key in the switch. 
function connectGET(url,callback){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            console.log(xmlhttp.responseText);
            switchCallback(callback,xmlhttp.responseText);
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

// http postrequest to server with callback
function connectPOST(url,parameters,callback){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            console.log(xmlhttp.responseText);
            switchCallback(callback,xmlhttp.responseText);
        }
    };
    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(parameters);
}

function switchCallback(callback, value){
	switch(callback){
		case "sayhello":
			alert("Hello " + value);
			break;
        case "new_idea":
            publishIdeaCallback(value);
            break;
        case "leave_idea":
            ideaHelperCallback("leave", value);
            break;    
		case "join_idea":
			ideaHelperCallback("join", value);
			break;
        case "idea_teamsize":
            teamsizeCallback(value);
            break;
        case "delete_idea":
            deleteIdeaCallback(value);
            break;
        case "update_idea":
            updateIdeaCallback(value);
            break;
        case "upgrade_idea":
            upgradeIdeaCallback(value);
            break;
	}
}