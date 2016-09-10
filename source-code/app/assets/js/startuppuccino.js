"use strict";

function Startuppuccino(){

    // Global variable to store data for the search function
    var data_set = [];

    this.downloadSearchResult = function() {
        // Download data
        this.get({url : "../app/controllers/search.php"},function(data){
            data_set = JSON.parse(data);
        });
    }

    this.search = function(text){

        text = text.toLowerCase();

        if(typeof text === "undefined" || text == null){
            this.layout.renderSearchResult(data_set);
            return;
        }

        var result_set = [],
            length = data_set.length,
            i;

        for (i = 0; i < length; i++) {
            var x = data_set[i];
            if( x.name.toLowerCase().search(text) != -1 ){
                result_set.push(x); 
            }
        }

        this.layout.renderSearchResult(result_set);

    }

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
    var elem = document.getElementById(target);
    elem.classList.remove("hidden_element");
}
Startuppuccino.prototype.layout.hideSection = function(target){
    var elem = document.getElementById(target);
    elem.classList.add("hidden_element");
}

Startuppuccino.prototype.layout.toggleMobileMenu = function(target){
    target.classList.toggle("mobile_menu__button--active");
    document.getElementById("main_menu").classList.toggle("main_menu--visible");
    document.getElementsByTagName("main")[0].classList.toggle("force--hidden");
    document.getElementsByClassName("bottom_header")[0].classList.toggle("force--hidden");
}

Startuppuccino.prototype.layout.toggleSearch = function() {
    document.getElementById("search").classList.toggle("search--visible");
}

// Render search results in the search section
Startuppuccino.prototype.layout.renderSearchResult = function(result_set) {
        
    var i,
        length = result_set.length,
        container = document.createElement("div"),
        wrapper = document.getElementById("search_result_list");

    var node = document.createElement("div"),
        a = document.createElement("a"),
        img = document.createElement("img"),
        labels = document.createElement("div"),
        p_name = document.createElement("p"),
        p_role = document.createElement("p");

    container.className = "search_results";
    node.className = "search_result";
    img.className = "search_result__pic";
    labels.className = "search_result__labels";
    p_name.className = "search_result__labels__name";
    p_role.className = "search_result__labels__role";

    labels.appendChild(p_name);
    labels.appendChild(p_role);
    a.appendChild(img);
    a.appendChild(labels);
    node.appendChild(a);

    for (i = 0; i < length; i++) {
        
        var x = result_set[i];
        
        var n = node.cloneNode(true);

        n.children[0].href = "../" + x.id;
        n.children[0].children[0].src = "../app/assets/pics/" + x.avatar;
        n.children[0].children[1].children[0].innerHTML = x.name;
        n.children[0].children[1].children[1].innerHTML = x.role;
        
        container.appendChild(n);
    }

    // Replace DOM with new results
    wrapper.innerHTML = "";
    wrapper.appendChild(container);

}



/* Initialize Startuppuccino */

if(typeof Sp === "undefined" || Sp === null){ 

    var Sp = new Startuppuccino();

}

/* Download search result after the has been loaded */

window.onload = function(){ Sp.downloadSearchResult(); };

/* Set search event listeners */
document.getElementById("search_input").oninput = function(){
    Sp.search(this.value);
}






/* ASK FOR HELP SECTION */

function showAskForHelp(){document.getElementById("askforhelp").setAttribute("style","top:0px");}
function hideAskForHelp(){document.getElementById("askforhelp").removeAttribute("style");}
function askForHelp(){
    var i = document.getElementById("askforhelp_id").value;
    var e = document.getElementById("askforhelp_email").value;
    var m = document.getElementById("askforhelp_message").value;
    if (i==""||e==""||m==""){alert("Please fill all inputs"+i+e+m);}
    else {Sp.get({url : "../app/controllers/askforhelp.php?i="+i+"&e="+e+"&m="+m}, function(response){alert(response);});}
    return false;
}