function Startuppuccino(){

    // Redirect to logout page
    this.logout = function() {
        window.location = "../logout/";
    }

    // http get request to server with callback
    this.get = function(data,callback){

        data.method = "get";

        this.http(data,callback);

    }

    // http post request to server with callback
    // content_type is and extra parameter to force the content type
    this.post = function(data,callback,content_type){
        
        // If content_type is define add info to data object
        if(typeof content_type !== "undefined"){
            data.type = content_type;
        }

        data.method = "post";

        this.http(data,callback);

    }

    this.http = function(data,callback){

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                console.log(xmlhttp.responseText);
                callback(xmlhttp.responseText);
            }
        };
        xmlhttp.open(data.method, data.url, true);
        if(data.method === "post"){
            if(typeof data.type !== "undefined" && data.type === "json"){
                xmlhttp.setRequestHeader("Content-type", "application/json");
            } else if(typeof data.type !== "undefined" && data.type !== ""){
                xmlhttp.setRequestHeader("Content-type", data.type);
            } else {
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");        
            }
        }
        xmlhttp.send(data.parameters);
    
    }

    /*
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
            case "edit_idea":
                editIdeaCallback(value);
                break;
            case "approve_idea":
            case "disapprove_idea":
            case "upgrade_idea":
                generalEducatorsCallback(value);
                break;
            case "like_idea":
                ideaHelperCallback("like", value);
                break;
            case "unlike_idea":
                ideaHelperCallback("unlike", value);
                break;
            case "new_comment_idea":
                submitCommentCallback(value);
                break;
            case "get_comments_idea":
                displayCommentsCallback(value);
                break;
            case "askforhelp":
                askForHelpCallback(value);
                break;
        }
    }
    */
}




Startuppuccino.prototype.helpers = {};

// helper to set multiple attributes on a node
Startuppuccino.prototype.helpers.setAttributes = function(element, attributes) {
    for(var key in attributes) {
        element.setAttribute(key, attributes[key]);
    }
}




Startuppuccino.prototype.layout = {};

// Loading screen
Startuppuccino.prototype.layout.showLoading = function(){
    document.getElementById("loading_screen").style = "display:block";
}

Startuppuccino.prototype.layout.hideLoading = function(){
    document.getElementById("loading_screen").style = "display:none";
}

// Helpers to easily hide or show sections
Startuppuccino.prototype.layout.showSection = function(target){
    elem = document.getElementById(target);
    elem.classList.remove("hidden_element");
}
Startuppuccino.prototype.layout.hideSection = function(target){
    elem = document.getElementById(target);
    elem.classList.add("hidden_element");
}




Startuppuccino.prototype.search = function(){

    var data;

    // Download data

    // Render lastest data

    // Search by name

}

/* Initialize Startuppuccino */

if(typeof Sp === "undefined" || Sp === null){ Sp = new Startuppuccino(); }
